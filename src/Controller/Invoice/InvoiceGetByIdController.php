<?php

namespace App\Controller\Invoice;

use App\Repository\InvoiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceGetByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/invoice/get/by/id", name="app_invoice_invoice_get_by_id")
     */
    public function get_info_invoice(InvoiceRepository $invoiceRepository): Response
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'erreur'
            );
        }

        $invoice = $invoiceRepository->findBy(['id' => $data["id"]]);

        if (empty($invoice)) {
            $output = array(
                'message' => 'Facture introuvable ! ',
                'status' => 'error'
            );
            return $this->json($output);
        }

        foreach ($invoice as $item) {
            $temp["id"] = $item->getId();
            $temp["reference"] = $item->getReference();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Information concernant la facture',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
