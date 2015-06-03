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
        $manager = $this->getDoctrine()->getManager();
        $tasks = $manager->getRepository('ToDoListBundle:Task')->findByTaskslist($idList);
        $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
        $content = $this->get('templating')->render('ToDoListBundle:Task:index.html.twig', ['tasks' => $tasks, 'taskList' => $taskList]);

        return new Response($content);
    }

    public function addTaskAction(Request $request, $idList)
    {
        $task = new Task();
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
            $task->setStatus(0);
            $task->setTaskslist($taskList);
            $manager->persist($task);
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_tasks', ['idList' => $idList]));
        }
        $content = $this->get('templating')->render('ToDoListBundle:Task:addTaskForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function editTaskAction(Request $request, $idList, $idTask)
    {
        $manager = $this->getDoctrine()->getManager();
        $task = $manager->getRepository('ToDoListBundle:Task')->find($idTask);
        if (empty($task)) {
            throw $this->createNotFoundException('La tâche ' . $idTask . ' n\'existe pas');
        }
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_tasks', ['idList' => $idList]));
        }
        $content = $this->get('templating')->render('ToDoListBundle:Task:addTaskForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function validateTaskAction($idList, $idTask)
    {
        $manager = $this->getDoctrine()->getManager();
        $task = $manager->getRepository('ToDoListBundle:Task')->find($idTask);
        if (empty($task)) {
            throw $this->createNotFoundException('La tâche ' . $idTask . ' n\'existe pas');
        }
        if ($task->getStatus() === 0) {
            $task->setStatus(1);
        }
        else {
            $task->setStatus(0);
        }
        $manager->flush();

        return $this->redirect($this->generateUrl('todolist_tasks', ['idList' => $idList]));
    }

    public function deleteTaskAction(Request $request)
    {
        $idList = $request->request->get('idList');
        $idTask = $request->request->get('idTask');
        $manager = $this->getDoctrine()->getManager();
        $task = $manager->getRepository('ToDoListBundle:Task')->find($idTask);
        if (empty($task)) {
            throw $this->createNotFoundException('La tâche ' . $idTask . ' n\'existe pas');
        }
        $manager->remove($task);
        $manager->flush();

        return $this->redirect($this->generateUrl('todolist_tasks', ['idList' => $idList]));
    }
}
