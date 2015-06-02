<?php

namespace ToDoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface TasksListInterface
{
    public function indexAction();

    public function getTasksListAction();

    public function newTaskListAction(Request $request);

    public function deleteTaskListAction($idList);
}
