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
        return $this->redirect($this->generateUrl("todolist_taskslist"));
    }

    public function getTasksListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ToDoListBundle:Taskslist');
        $tasksList = $repository->findAll();
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:index.html.twig', ['taskslist' => $tasksList]);

        return new Response($content);
    }

    public function newTaskListAction(Request $request)
    {
        $taskList = new Taskslist();
        $form = $this->createForm(new TasksListType(), $taskList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($taskList);
            $manager->flush();

            return $this->redirect($this->generateUrl("todolist_taskslist"));
        }

        return $this->render('ToDoListBundle:TasksList:newTaskListForm.html.twig', ["form" => $form->createView()]);
    }
}
