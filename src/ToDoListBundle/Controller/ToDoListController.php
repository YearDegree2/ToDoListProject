<?php

namespace ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ToDoListController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('ToDoListBundle:ToDoList:index.html.twig');

        return new Response($content);
    }
}
