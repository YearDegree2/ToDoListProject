<?php

namespace ToDoListBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testGetTasks()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist/1/tasks');
        $this->assertTrue($crawler->filter('html:contains("Tasks")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Manage your Tasks")')->count() > 0);
    }

    public function testAddTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist/1/tasks/add');
        $this->assertTrue($crawler->filter('html:contains("Tasks")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Create your Task")')->count() > 0);
    }

    public function testEditTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/taskslist/1/tasks/edit/3');
        $this->assertTrue($crawler->filter('html:contains("Tasks")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Update your Task")')->count() > 0);
    }
}