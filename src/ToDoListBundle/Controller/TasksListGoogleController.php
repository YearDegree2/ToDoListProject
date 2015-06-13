<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/06/2015
 * Time: 19:59
 */

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//use HappyR\Google\ApiBundle\Services\GoogleClient;

class TasksListGoogleController extends Controller
{
    private function getGoogleServiceTasks()
    {
        $client = $this->container->get("happyr.google.api.client");
        $googleClient = $client->getGoogleClient();
        $this->securityContext = $this->get("security.context");
        $token = $this->securityContext->getToken();
        $googleClient->setAccessToken($token->getUser());

        return new \Google_Service_Tasks($googleClient);
    }

    public function getTasksListAction()
    {
        $service = $this->getGoogleServiceTasks();

        return new Response("dfgdfg");
    }

    public function addTaskListAction(Request $request)
    {

    }

    public function editTaskListAction(Request $request, $idList)
    {

    }

    public function deleteTaskListAction(Request $request)
    {

    }
}
