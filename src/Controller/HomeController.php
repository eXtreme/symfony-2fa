<?php

namespace App\Controller;

use App\Security\AppUserProvider;
use Scheb\TwoFactorBundle\Security\TwoFactor\QrCode\QrCodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /** @Route("/", name="home") */
    public function home(Request $request): Response
    {
        return $this->render('home/home.html.twig', [
            'status' => $this->isGranted('IS_AUTHENTICATED_FULLY') ? 'authenticated' : ($this->isGranted('IS_AUTHENTICATED_2FA_IN_PROGRESS') ? '2fa' : 'anonymous'),
        ]);
    }

    /** @Route("/qr-code", name="qr_code") */
    public function qrCode(QrCodeGenerator $qrCodeGenerator, AppUserProvider $appUserProvider): Response
    {
        $qrCode = $qrCodeGenerator->getTotpQrCode($appUserProvider->loadUserByUsername('demo'));

        return new Response($qrCode->writeString(), 200, ['Content-Type' => 'image/png']);
    }
}
