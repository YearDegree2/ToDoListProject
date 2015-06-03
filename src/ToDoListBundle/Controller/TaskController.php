<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToDoListBundle\Form\Type\TaskType;
use ToDoListBundle\Entity\Task;

class TaskController extends Controller implements TaskInterface
{
    public function getTasksAction($idList)
    {
        $repository = $this->getDoctrine()->getRepository('ToDoListBundle:Task');
        $tasks = $repository->findByTaskslist($idList);
        $content = $this->get('templating')->render('ToDoListBundle:Task:index.html.twig', ['tasks' => $tasks, 'idList' => $idList]);

        return new Response($content);
    }

    public function addTaskAction(Request $request, $idList)
    {
        $task = new Task();
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $tasklist = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
            $task->setStatus(0);
            $task->setTaskslist($tasklist);
            $manager->persist($task);
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_tasks', ['idList' => $idList]));
        }
        $content = $this->get('templating')->render('ToDoListBundle:Task:addTaskForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }
}
