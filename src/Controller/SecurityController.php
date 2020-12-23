<?php

namespace App\Controller;

use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorTokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController
{
    /** @Route("/login", name="api_login") */
    public function login(Request $request): Response
    {
        return new Response('should never be reached');
    }

    /** @Route("/logout", name="api_logout") */
    public function logout(Request $request): Response
    {
        return new Response('should never be reached');
    }

    /** @Route("/2fa", name="api_2fa") */
    public function twoFactor(Request $request, TokenStorageInterface $tokenStorage): Response
    {
        if ($tokenStorage->getToken() instanceof TwoFactorTokenInterface) {
            return new JsonResponse(['status' => '2fa']);
        }

        return new JsonResponse(['status' => 'success']);
    }

    /** @Route("/2fa_check", name="api_2fa_check") */
    public function twoFactorCheck(Request $request): Response
    {
        return new Response('should never be reached');
    }
}
