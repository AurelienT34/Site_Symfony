<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        //$content = "Vous n'avez pas les droits suffisant pour accéder à cette page";
        $response = new RedirectResponse($this->router->generate('home'));

        return new RedirectResponse($this->router->generate('home'));
        //return new Response($content, 403);
    }
}
