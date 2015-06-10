<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/06/2015
 * Time: 19:59
 */

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

//use HappyR\Google\ApiBundle\Services\GoogleClient;

class TasksListGoogleController extends Controller
{
    public function getGoogleServiceTasksAction()
    {
        $client = $this->container->get("happyr.google.api.client");
        $googleClient = $client->getGoogleClient();
        $this->securityContext = $this->get("security.context");
        $token = $this->securityContext->getToken();
        $googleClient->setAccessToken($token->getUser());

        new \Google_Service_Tasks($googleClient);
        return new Response('hector');
    }
}