<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToDoListBundle\Form\Type\TasksListType;
use ToDoListBundle\Entity\Taskslist;
use HappyR\Google\ApiBundle\Services;
use HappyR\Google\ApiBundle\DependencyInjection;

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
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:addTaskListForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function editTaskListAction(Request $request, $idList)
    {
        $manager = $this->getDoctrine()->getManager();
        $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
        if (empty($taskList)) {
            throw $this->createNotFoundException('La liste  ' . $idList . ' n\'existe pas');
        }
        $form = $this->createForm(new TasksListType(true), $taskList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirect($this->generateUrl('todolist_taskslist'));
        }
        $content = $this->get('templating')->render('ToDoListBundle:TasksList:editTaskListForm.html.twig', ['form' => $form->createView()]);

        return new Response($content);
    }

    public function deleteTaskListAction(Request $request)
    {
        $idList = $request->request->get('idList');
        $manager = $this->getDoctrine()->getManager();
        $taskList = $manager->getRepository('ToDoListBundle:Taskslist')->find($idList);
        if (empty($taskList)) {
            throw $this->createNotFoundException('La liste ' . $idList . ' n\'existe pas');
        }
        $manager->remove($taskList);
        $manager->flush();

        return $this->redirect($this->generateUrl('todolist_taskslist'));
    }

    public function testHappyBundleAction()
    {
        $client = $this->container->get("happyr.google.api.client");

        $googleClient = $client->getGoogleClient();
        $googleClient->setScopes(array(
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ));

        $service = new \Google_Service_Tasks($googleClient);
        if (isset($_GET['logout'])) { // logout: destroy token
            unset($_SESSION['token']);
            die('Logged out.');
        }

        if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
            $googleClient->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
        }

        if (isset($_SESSION['token'])) { // extract token from session and configure client
            $token = $_SESSION['token'];
            $googleClient->setAccessToken($token);
        }

        if (!$googleClient->getAccessToken()) { // auth call to google
            $authUrl = $googleClient->createAuthUrl();
            header("Location: ".$authUrl);
            die;
        }
        return new Response("jean");
    }
}
