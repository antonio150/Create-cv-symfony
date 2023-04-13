<?php

namespace App\Controller\Invoice;

use App\Repository\InvoiceRepository;
use App\Repository\PaymentRepository;
use App\Repository\PointOfSaleRepository;
use App\Repository\SalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceListController extends AbstractController
{
    /**
     * @Route("/api/v1/invoice/list", name="app_invoice_list")
     */
    public function listInvoice(
        InvoiceRepository $invoiceRepository,
        SalesRepository $salesRepository,
        PointOfSaleRepository $pointOfSaleRepository,
        PaymentRepository $paymentRepository
    ): JsonResponse {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $invoice =  $invoiceRepository->findBy(['is_deleted' => false]);
        } else {
            $pointOfSaleID = $data["pointOfSaleID"];
            $pointOfSale = $pointOfSaleRepository->find($pointOfSaleID);
            $invoice = $invoiceRepository->findBy(
                [
                    'pointOfSale' => $pointOfSale,
                    'is_deleted' => false
                ],
                array('id' => 'DESC')
            );
        }
        foreach ($invoice as $item) {
            $temp["id"] = $item->getId();
            $temp["reference"] = $item->getReference();
            $temp["customer"] = (!empty($item->getCustomer())) ? $item->getCustomer()->getNom() : '-';
            $temp["pointOfSale"] = $item->getPointOfSale()->getName();
            $temp["paymentStatus"] = $item->getPaymentStatus()->getStatus();
            $temp["invoiceDate"] = $item->getInvoiceDate();
            $sum =  $salesRepository->getSumSales($item->getId());
            $temp["sum"] = $sum["total"];

            // Payementreceived
            $payment = $paymentRepository->findBy(['invoice' => $item]);
            foreach ($payment as $i) {
                $temp["paymentReceived"] = $i->getPaymentReceived();
                $temp["leftToPay"] = $i->getLeftToPay();
            }

            // reste à payer 
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des factures',
            'data' => $output,
            'status' => 'success'
        ]);
    }

    /**
     * @Route("/api/v1/view-pdf/invoice/{name}", name="viewPdfPaye")
     */
    public function viewPdfPaye(string $name): Response
    {
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/ticket';
        $pdfFilepath =  $publicDirectory . '/' . $name . '.pdf';
        return $this->file($pdfFilepath);
    }
}
