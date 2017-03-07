<?php

namespace IIT\AllSpeakBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('.index')->count());
    }

    public function testSurveyUnauthenticated()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/survey');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testSurveyAuthenticated()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'test',
            'PHP_AUTH_PW'   => 'test',
        ]);

        $crawler = $client->request('GET', '/survey');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('iframe')->count());
    }
}
