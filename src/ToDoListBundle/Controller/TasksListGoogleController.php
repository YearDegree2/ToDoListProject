<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToDoListBundle\Form\Type\TasksListType;

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
        $tasksList = $service->tasklists->listTasklists();
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:indexGoogle.html.twig', ['taskslist' => $tasksList]);

        return new Response($content);
    }

    public function addTaskListAction(Request $request)
    {
        $service = $this->getGoogleServiceTasks();
        $taskList = new \Google_Service_Tasks_TaskList();
        $form = $this->createForm(new TasksListType(false, '\Google_Service_Tasks_TaskList', true));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $taskList->setTitle($form->getData()['title']);
            $service->tasklists->insert($taskList);

            return $this->redirect($this->generateUrl("todolist_google_taskslist"));
        }
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:addTaskListGoogleForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function editTaskListAction(Request $request, $idList)
    {
        $service = $this->getGoogleServiceTasks();
        $taskList = $service->tasklists->get($idList);
        $form = $this->createForm(new TasksListType(true, '\Google_Service_Tasks_TaskList', true), $taskList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $service->tasklists->update($taskList->getId(), $taskList);

            return $this->redirect($this->generateUrl("todolist_google_taskslist"));
        }
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:editTaskListGoogleForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function deleteTaskListAction(Request $request)
    {
        $service = $this->getGoogleServiceTasks();
        $idList = $request->request->get('idList');
        $service->tasklists->delete($idList);

        return $this->redirect($this->generateUrl("todolist_google_taskslist"));
    }
}
