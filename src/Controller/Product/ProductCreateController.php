<?php

namespace App\Controller\Product;

use App\Entity\Collector;
use App\Entity\Product;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/product/create", name="app_product_create")
     */
    public function create(): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();


        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["name"]) || empty($data["price"]) || empty($data["quantity"]) || empty($data["reference"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $name = isset($data["name"]) ? $data["name"] : NULL;
                $price = isset($data["price"]) ? $data["price"] : NULL;
                $qte = isset($data["quantity"]) ? $data["quantity"] : NULL;
                $description = isset($data["description"]) ? $data["description"] : NULL;
                $reference = isset($data["reference"]) ? $data["reference"] : NULL;


                $product = new Product($name, $description, $price, $qte, $reference);
                try {
                    $em->persist($product);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Nouveau produit enregistré avec succès !"
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
