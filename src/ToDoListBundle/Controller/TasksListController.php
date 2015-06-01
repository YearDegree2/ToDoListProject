<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TasksListController extends Controller implements TasksListInterface
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl("todolist_taskslist_list"));
    }

    public function getTasksListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ToDoListBundle:Taskslist');
        $tasksList = $repository->findAll();
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:index.html.twig', ['taskslist' => $tasksList]);

        return new Response($content);
    }
}
