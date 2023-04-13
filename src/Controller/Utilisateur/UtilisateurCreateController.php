<?php

namespace App\Controller\Utilisateur;

use App\Entity\Collector;
use App\Entity\Utilisateur;
use App\Repository\CollectorRepository;
use App\Repository\UserTypeRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurCreateController extends AbstractController
{
    private $_passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->_passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/api/v1/user/create", name="app_user_create")
     */
    public function create(UserTypeRepository $userTypeRepository, UtilisateurRepository $utilisateurRepository, CollectorRepository $collectorRepository): JsonResponse
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
            if (empty($data["username"]) || empty($data["password"]) || empty($data["typeUser"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $username = isset($data["username"]) ? $data["username"] : NULL;
                $password = isset($data["password"]) ? $data["password"] : NULL;
                $name = isset($data["name"]) ? $data["name"] : NULL;
                $firstName = isset($data["firstName"]) ? $data["firstName"] : NULL;
                $type = isset($data["type"]) ? $data["type"] : NULL;
                $adresse = isset($data["adresse"]) ? $data["adresse"] : NULL;
                $typeUserId = isset($data["typeUser"]) ? $data["typeUser"] : NULL;

                $typeUser = $userTypeRepository->find($typeUserId);
                
                if (empty($typeUser)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Type Utilisateur introuvable !"
                    );
                    return $this->json($output);
                }

                if ($typeUser->isCollector()) {
                    $credit = isset($data["credit"]) ? $data["credit"] : NULL;
                    if (empty($data["credit"])) {
                        $output = array(
                            'message' => 'Merci de remplir le credit par défaut du collecteur ! ',
                            'status' => 'error'
                        );
                     return $this->json($output);
                    }
                }


                $user = new Utilisateur($username, $password, $name, $firstName, $type, $adresse, $typeUser);

                $user->setPassword($this->_passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                ));

                try {
                    $utilisateurRepository->add($user, true);
                    if ($typeUser->isCollector()) {
                        // Creation Collector
                        $cin = $typeUserId = isset($data["cin"]) ? $data["cin"] : NULL;
                        $credit = $typeUserId = isset($data["credit"]) ? $data["credit"] : NULL;
                        $collector = new Collector($cin, $credit, $user);
                        $collectorRepository->add($collector, true);
                    }
                    $output = array(
                        "status" => "success",
                        "message" => "Nouveau utilisateur enregistré avec succès !",
                        "Id" => $user->getId()
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
