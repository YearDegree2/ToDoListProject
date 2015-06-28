<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GoogleController extends Controller
{
    public function callbackAction(Request $request)
    {
        if ($request->query->get('error')) {
            $content = $this->get('templating')->render('ToDoListBundle:Google:error.html.twig');

            return new Response($content);
        }

        if ($request->query->get('code')) {
            $googleClient = $this->get('happyr.google.api.client');
            $googleClient->authenticate($request->query->get('code'));
            $accessToken = $googleClient->getAccessToken();
            $this->securityContext = $this->get("security.context");
            $token = $this->securityContext->getToken();
            $token = new PreAuthenticatedToken(
                $accessToken,
                $token->getCredentials(),
                $token->getProviderKey(),
                [ 'ROLE_HAS_TOKEN' ]
            );
            $this->securityContext->setToken($token);
        }

        return $this->redirect($this->generateUrl('todolist_google_taskslist'));
    }

    public function exitAction()
    {
        $this->get('security.context')->setToken();

        return $this->redirect($this->generateUrl('todolist_homepage'));
    }
}
