<?php

namespace App\Controller\Invoice;

use App\Entity\Invoice;
use App\Entity\Payment;
use App\Entity\Sales;
use App\Repository\ClientRepository;
use App\Repository\InvoiceRepository;
use App\Repository\PaymentRepository;
use App\Repository\PaymentStatusRepository;
use App\Repository\PointOfSaleRepository;
use App\Repository\ProductRepository;
use App\Repository\SalesRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceSalesDirectCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/invoice/sales/direct/create", name="app_invoice_sales_direct_create")
     */
    public function create(
        InvoiceRepository $invoiceRepository,
        PointOfSaleRepository $pointOfSaleRepository,
        PaymentStatusRepository $paymentStatusRepository,
        ProductRepository $productRepository,
        SalesRepository $salesRepository,
        PaymentRepository $paymentRepository
    ): JsonResponse {

        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {

            if (empty($data["pointOfSale"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $pointOfSaleID = isset($data["pointOfSale"]) ? $data["pointOfSale"] : NULL;
                $products = isset($data["products"]) ? $data["products"] : NULL;
                $pointOfSale = $pointOfSaleRepository->find($pointOfSaleID);
                if (empty($pointOfSale)) {
                    $output = array(
                        'message' => 'Point de vente introuvable ! ',
                        'status' => 'error'
                    );
                    return $this->json($output);
                }
                $paymentStatus = $paymentStatusRepository->find(1); //  payé par défaut
                $invoiceNumber = ($pointOfSale->getInvoiceNumber() + 1);

                if (strlen($invoiceNumber) == 1) {
                    $indice = "000" . $invoiceNumber;
                } elseif (strlen($invoiceNumber) == 2) {
                    $indice = "00" . $invoiceNumber;
                } elseif (strlen($invoiceNumber) == 3) {
                    $indice = "0" . $invoiceNumber;
                }
                $ref = "FAC/" . $pointOfSale->getSigle() . "/" . $indice;
                try {
                    $invoiceDate = new DateTime();
                    $invoice = new Invoice($pointOfSale, $paymentStatus, $ref, $invoiceDate);
                    $invoiceRepository->add($invoice, true);
                    $totalAmount = 0;
                    foreach ($products as $item) {
                        $productID = $item["product"];
                        $product = $productRepository->find($productID);
                        if (empty($product)) {
                            $invoiceRepository->remove($invoice, true);
                            $output = array(
                                'message' => 'Produit introuvable - Facture supprimée ! ',
                                'status' => 'error'
                            );
                            return $this->json($output);
                        }

                        // Enregistrement vente = designation 
                        $sales = new Sales();
                        $sales->setProduct($product);
                        $sales->setQuantity($item["quantity"]);
                        $sales->setUnitPrice($item["unit_price"]);
                        $sales->setAmount($item["amount"]);
                        $sales->setCreatedAt(new DateTime());
                        $sales->setIsDeleted(false);
                        $sales->setInvoice($invoice);
                        $salesRepository->add($sales, true);
                        $totalAmount += $item["amount"];
                    }

                    // UPDATE INVOICE NUMBER POINT OF SALES
                    $pointOfSaleRepository->updateInvoiceNumber($pointOfSale->getId(), $invoiceNumber, true);

                    $balance = $pointOfSale->getBalance() + $totalAmount;
                    // // Enregistrement Paiement
                    $payment = new Payment();
                    $payment->setInvoice($invoice);
                    $payment->setPaymentReceived($totalAmount);
                    $payment->setPaymentDate(new DateTime());
                    $payment->setAmountInvoice($totalAmount);
                    $payment->setLeftToPay(0.000);
                    $payment->setCreatedAt(new DateTime());
                    $payment->setBalancePos($balance);
                    $paymentRepository->add($payment, true);

                    $pointOfSaleRepository->updateBalance($pointOfSale, $balance, true);

                    $output = array(
                        'message' => 'Vente enregistré avec succès ! ',
                        'status' => 'success'
                    );

                    // Generate PDF 
                    $pdfOptions = new Options();
                    $pdfOptions->set('defaultFont', 'Arial');
                    $pdfOptions->set('DOMPDF_ENABLE_REMOTE', true);
                    $pdfOptions->set('isRemoteEnabled', TRUE);
                    // Instantiate Dompdf with our options
                    $dompdf = new Dompdf($pdfOptions);
                    // Retrieve the HTML generated in our twig file
                    $html = $this->renderView('invoice/invoiceTicket.html.twig', [
                        'pointOfSale' => $pointOfSale->getName(),
                        'date' => date_format(new DateTime(),"d/m/Y/ H:i:s"),
                        'reference' => $ref,
                        'articles' => $products,
                        'total' => $totalAmount
                    ]);
                    // Load HTML to Dompdf
                    $dompdf->loadHtml($html);
                    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                    $dompdf->setPaper('A4', 'portrait');
                    // Render the HTML as PDF
                    $dompdf->render();
                    // Store PDF Binary Data
                    $outputs = $dompdf->output();
                    // In this case, we want to write the file in the public directory
                    $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/ticket';
                    // e.g /var/www/project/public/mypdf.pdf
                    $pdfFilepath =  $publicDirectory . '/'.str_replace("/","-",$ref).'.pdf';
                    // Write file to the desired path
                    file_put_contents($pdfFilepath, $outputs);
                } catch (Exception $ex) {
                    $output = array(
                        "status" => "error",
                        "message" => $ex->getMessage()
                    );
                }
            }
        }

        return $this->json($output);
    }
}
