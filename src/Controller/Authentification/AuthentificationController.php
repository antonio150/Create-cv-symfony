<?php

namespace App\Controller\Authentification;

use Firebase\JWT\JWT;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/api/v1/auth/login", name="app_authentification")
     */
    public function auth(UtilisateurRepository $userRepository, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $request = Request::createFromGlobals();

        $data = json_decode($request->getContent(), true);

        $user = $userRepository->findOneBy(
            [
                'username'=> $data["username"], 
                'is_blocked'=> false
            ]);
        
        if (!$user || !$encoder->isPasswordValid($user, $data["password"])) {
            return $this->json([
                    'message' => "Nom d'utilisateur ou mot de passe erroné ou utilisateur bloqué!",
            ]);
        }

        
        $payload = [
            "user" => $user->getUserIdentifier(),
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "exp"  => (new \DateTime())->modify("+5 hours")->getTimestamp(),
            "userType" => $user->getUserType()->getId()
            
        ];

        $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS256');
        return $this->json([
            'message' => 'success',
            'token' => sprintf('Bearer %s', $jwt),
            'bearer' => $jwt
        ]);
        
    }
}
