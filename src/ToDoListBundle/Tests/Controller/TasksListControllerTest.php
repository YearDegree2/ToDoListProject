<?php

namespace ToDoListBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TasksListControllerTest extends WebTestCase
{
    public function testGetTasksList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist');
        $this->assertTrue($crawler->filter('html:contains("TasksList")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Manage your TasksList")')->count() > 0);
    }

    public function testAddTaskList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist/add');
        $this->assertTrue($crawler->filter('html:contains("TasksList")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Create your TaskList")')->count() > 0);
    }

    public function testEditTaskList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist/edit/1');
        $this->assertTrue($crawler->filter('html:contains("TasksList")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Update your TaskList")')->count() > 0);
    }
}
