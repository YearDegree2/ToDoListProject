<?php

namespace ToDoListBundle\Controller;

interface TaskInterface
{
    public function getTasksAction($idList);
}
