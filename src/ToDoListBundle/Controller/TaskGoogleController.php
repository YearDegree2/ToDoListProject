<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToDoListBundle\Form\Type\TaskType;

class TaskGoogleController extends Controller implements TaskInterface
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

    public function getTasksAction($idList)
    {
        $service = $this->getGoogleServiceTasks();
        $tasks = $service->tasks->listTasks($idList);
        $taskList = $service->tasklists->get($idList);
        $content = $this->get('templating')->render('ToDoListBundle:Task:indexGoogle.html.twig', ['tasks' => $tasks, 'taskList' => $taskList]);

        return new Response($content);
    }

    public function addTaskAction(Request $request, $idList)
    {
        $service = $this->getGoogleServiceTasks();
        $task = new \Google_Service_Tasks_Task();
        $form = $this->createForm(new TaskType(false, '\Google_Service_Tasks_Task', true));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $task->setTitle($form->getData()['title']);
            $task->setParent($idList);
            $service->tasks->insert($idList, $task);

            return $this->redirect($this->generateUrl("todolist_google_tasks", ["idList" => $idList]));
        }
        $content = $this->get('templating')->render('ToDoListBundle:Task:addTaskGoogleForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function editTaskAction(Request $request, $idList, $idTask)
    {
        $service = $this->getGoogleServiceTasks();
        $task = $service->tasks->get($idList, $idTask);
        $form = $this->createForm(new TaskType(true, '\Google_Service_Tasks_Task', true), $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $service->tasks->update($idList, $idTask ,$task);

            return $this->redirect($this->generateUrl("todolist_google_tasks", ["idList" => $idList]));
        }
        $content = $this->get('templating')->render('ToDoListBundle:Task:editTaskGoogleForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function validateTaskAction($idList, $idTask)
    {
        $service = $this->getGoogleServiceTasks();
        $task = $service->tasks->get($idList, $idTask);
        if ($task->getStatus() === "completed") {
            $task->setStatus("needsAction");
            $task->setCompleted(null);
        } else {
            $task->setStatus("completed");
        }
        $service->tasks->update($idList, $idTask ,$task);

        return $this->redirect($this->generateUrl("todolist_google_tasks", ["idList" => $idList]));
    }

    public function deleteTaskAction(Request $request)
    {
        $service = $this->getGoogleServiceTasks();
        $idList = $request->request->get('idList');
        $idTask = $request->request->get('idTask');
        $service->tasks->delete($idList, $idTask);

        return $this->redirect($this->generateUrl("todolist_google_tasks", ["idList" => $idList]));
    }
}
