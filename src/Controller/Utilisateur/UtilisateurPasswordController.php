<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use App\Services\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurPasswordController extends AbstractController
{
    private $_passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->_passwordEncoder = $passwordEncoder;
    }
    

    /**
     * @Route("/api/v1/user/pwd", name="app_user_pwd")
     */
    public function modif(UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Utilisateur::class);

        $id = isset($data["id"]) ? $data["id"] : NULL;
        $password = isset($data["password"]) ? $data["password"] : NULL;

        if ($id == NULL) {
            $output = array(
                "status" => "erreur",
                "message" => "Veuillez renseigner l'id de l'utilisateur."
            );
        } else {

            $helper = new Helper();
            $isCorrect = $helper->_is_correct_password($password);
            
            if (!$isCorrect) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Votre mot de passe doit contenir au moins un majuscule, un chiffre et au moins 8 caractères."
                );
            } else {
                $parameter = array(
                    "id" => $data["id"]
                );
                $user = $repository->find($parameter);
                if (!empty($user)) {
                    $oldpassword = isset($data["oldpassword"]) ? $data["oldpassword"] : NULL;

                    if (!$encoder->isPasswordValid($user, $oldpassword)) {
                        $output = array(
                            "status" => "erreur",
                            "message" => "Le mot de passe que vous avez entré est incorrect."
                        );
                        return $this->json($output);
                    }
                    if (!empty($password)) {
                        $user = $repository->findOneBy([
                            'id' => $id
                        ]);

                        $user->setPlainPassword($password);
                        $user->setPassword(
                            $this->_passwordEncoder->encodePassword(
                                $user,
                                $user->getPlainPassword()
                            )
                        );

                        $user->setUpdatedAt(new \DateTime());

                        $em->persist($user);
                        $em->flush();

                        $output = array(
                            "status" => "success",
                            "message" => "Modification mot de passe éffectuée avec succès."
                        );
                    }
                }
                return $this->json($output);
            }
        }
        return $this->json($output);
    }
}
