<?php

namespace App\Controller\Purchase;

use App\Repository\PurchaseRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseUpdateStatusController extends AbstractController
{
    /**
     * @Route("/api/v1/purchase/update/status", name="app_purchase_update_status")
     */
    public function update(PurchaseRepository $purchaseRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

         if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["id"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                try {
                    $purchaseRepository->updateStatus($data, true);
                    $output = array(
                        "status" => "success",
                        "message" => "Statur modifié avec succès !",
                    );
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
