<?php

namespace ToDoListBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TasksListGoogleControllerTest extends WebTestCase
{
    public function testVerifyAskConnection()
    {
       /* $client = static::createClient();
        $crawler = $client->request('GET', '/google/taskslist');
        var_dump($client->getResponse()->getContent());
        $this->assertTrue($crawler->filter('html:contains("Google")')->count() > 0);
        //$this->assertNotTrue($crawler->filter('html:contains("TasksList Google")')->count() > 0);
       */
    }
}