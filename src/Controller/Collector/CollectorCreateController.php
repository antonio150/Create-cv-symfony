<?php

namespace App\Controller\Collector;

use App\Entity\Collector;
use App\Entity\Utilisateur;
use App\Repository\CollectorRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectorCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/create", name="app_collector_create")
     */
    public function create(CollectorRepository $collectorRepository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'erreur'
            );
        } else {
            if (empty($data["user"]) || empty($data["credit"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'erreur'
                );
            } else {
                $userId = isset($data["user"]) ? $data["user"] : NULL;
                $credit = isset($data["credit"]) ? $data["credit"] : NULL;
                $cin = isset($data["cin"]) ? $data["cin"] : NULL;

                $parameter = array(
                    "id" => $userId
                );
                $reposUser = $em->getRepository(Utilisateur::class);
                $user = $reposUser->find($parameter);

                if (empty($user)) {
                    $output = array(
                        "status" => "erreur",
                        "message" => "Utilisateur introuvable !"
                    );
                } else {
                    $collector = new Collector($cin, $credit, $user);
                    try {
                        $em->persist($collector);
                        $em->flush();

                        $output = array(
                            "status" => "success",
                            "message" => "Collecteur enregistré avec succès !"
                        );
                    } catch (Exception $ex) {

                        $output = array(
                            "status" => "erreur",
                            "message" => $ex->getMessage()
                        );
                    }
                }
            }
        }
        return $this->json($output);
    }
}
