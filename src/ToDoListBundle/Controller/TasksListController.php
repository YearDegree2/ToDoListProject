<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToDoListBundle\Form\Type\TasksListType;
use ToDoListBundle\Entity\Taskslist;

class TasksListController extends Controller implements TasksListInterface
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('todolist_taskslist'));
    }

    public function getTasksListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ToDoListBundle:Taskslist');
        $tasksList = $repository->findAll();
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:index.html.twig', ['taskslist' => $tasksList]);

        return new Response($content);
    }

    public function addTaskListAction(Request $request)
    {
        $taskList = new Taskslist();
        $form = $this->createForm(new TasksListType(), $taskList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($taskList);
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_taskslist'));
        }
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:newTaskListForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function updateTaskListAction($idList, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
        if (empty($taskList)) {
            throw $this->createNotFoundException('La liste  ' . $idList . ' n\'existe pas');
        }
        $form = $this->createForm(new TasksListType(), $taskList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_taskslist'));
        }
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:newTaskListForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function deleteTaskListAction($idList)
    {
        $manager = $this->getDoctrine()->getManager();
        $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
        if (empty($taskList)) {
            throw $this->createNotFoundException('La liste ' . $idList . ' n\'existe pas');
        }
        $manager->remove($taskList);
        $manager->flush();

        return $this->redirect($this->generateUrl('todolist_taskslist'));
    }
}
