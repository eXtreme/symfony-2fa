<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onLogoutSuccess(Request $request)
    {
        $defaultFormat = $request->getPreferredFormat();
        if (false === strpos($request->getRequestFormat($defaultFormat), 'json')) {
            return new RedirectResponse($this->urlGenerator->generate('home'), Response::HTTP_SEE_OTHER);
        }

        return new JsonResponse([ 'status' => 'success' ]);
    }
}
