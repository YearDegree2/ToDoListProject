<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller implements TaskInterface
{
    public function getTasksAction($idList)
    {
        $repository = $this->getDoctrine()->getRepository('ToDoListBundle:Task');
        $tasks = $repository->findByTaskslist($idList);
        $content = $this->get('templating')->render('ToDoListBundle:Task:index.html.twig', ['tasks' => $tasks, 'idList' => $idList]);

        return new Response($content);
    }
}
