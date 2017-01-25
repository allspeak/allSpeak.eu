<?php

namespace IIT\AllSpeakBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }

    public function testSurvey()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/survey');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
