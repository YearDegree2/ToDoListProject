<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller implements TaskInterface
{
    public function getTasksAction($idList)
    {
        $repository = $this->getDoctrine()->getRepository('ToDoListBundle:Task');
        $tasks = $repository->findByTaskslist($idList);

        return $this->render('ToDoListBundle:Task:index.html.twig', array('tasks' => $tasks, 'idList' => $idList));
    }
}
