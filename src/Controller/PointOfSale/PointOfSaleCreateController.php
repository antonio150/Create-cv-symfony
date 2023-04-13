<?php

namespace App\Controller\PointOfSale;

use App\Entity\PointOfSale;
use App\Repository\PointOfSaleRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/create", name="app_point_of_sale_create")
     */
    public function create(PointOfSaleRepository $pointOfSaleRepository, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["name"]) || empty($data["manager"]) || empty($data["adress"]) || empty($data["acronym"]) || empty($data["balance"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $name = isset($data["name"]) ? $data["name"] : NULL;
                $managerID = isset($data["manager"]) ? $data["manager"] : NULL;
                $adress = isset($data["adress"]) ? $data["adress"] : NULL;
                $contact = isset($data["contact"]) ? $data["contact"] : NULL;
                $acronym = isset($data["acronym"]) ? $data["acronym"] : NULL;
                $balance = isset($data["balance"]) ? $data["balance"] : NULL;

                $manager = $utilisateurRepository->find($managerID);
                if (empty($manager)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Manager introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    $pointOfSale = new PointOfSale($manager, $name, $adress, $contact, $acronym);
                    $pointOfSale->setBalance($balance);
                    
                    $pointOfSaleRepository->add($pointOfSale, true);

                    $output = array(
                        "status" => "success",
                        "message" => "Point de vente créé avec succès !"
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
