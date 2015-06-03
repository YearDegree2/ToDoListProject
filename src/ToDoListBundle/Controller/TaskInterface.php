<?php

namespace ToDoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface TaskInterface
{
    public function getTasksAction($idList);

    public function addTaskAction(Request $request, $idList);

    public function updateTaskAction(Request $request, $idList, $idTask);
}
