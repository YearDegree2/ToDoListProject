<?php

namespace ToDoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface TaskInterface
{
    public function getTasksAction($idList);

    public function addTaskAction(Request $request, $idList);

    public function editTaskAction(Request $request, $idList, $idTask);

    public function validateTaskAction($idList, $idTask);

    public function deleteTaskAction(Request $request);
}
