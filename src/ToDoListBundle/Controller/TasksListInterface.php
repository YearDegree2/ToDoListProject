<?php

namespace ToDoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface TasksListInterface
{
    public function indexAction();

    public function getTasksListAction();

    public function addTaskListAction(Request $request);

    public function editTaskListAction(Request $request, $idList);

    public function deleteTaskListAction(Request $request);
}
