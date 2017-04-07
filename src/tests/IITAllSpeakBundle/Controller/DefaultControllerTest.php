<?php

namespace IIT\AllSpeakBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $container;

    private function getSurveyTakerClient() {
        $surveyTakerPassword = $this->container->getParameter('surveytaker_password');

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'surveytaker',
            'PHP_AUTH_PW'   => $surveyTakerPassword,
        ]);

        return $client;
    }

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

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
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/survey');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('form')->count());
    }

    public function testSurveySubmitNotValid()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/survey');

        $form = $crawler->selectButton('Conferma')->form();
        $form['form[gender]'] = 'M';

        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/survey$/', $crawler->getUri());
        $this->assertGreaterThan(0, $crawler->filter('.has-error')->count());
    }

    public function testSurveySubmitValid()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/survey');

        $form = $crawler->selectButton('Conferma')->form();
        $form['form[gender]'] = 'F';
        $form['form[birthYear]'] = '1946';
        $form['form[diagnosisYear]'] = '1985';
        $form['form[alsfrsr]'] = '34';
        $form['form[verbalScore]'] = '3';
        $form['form[diagnosis]'] = 'S';
        $form['form[sentences][0]'] = '12';
        $form['form[sentences][1]'] = '11';
        $form['form[sentences][2]'] = '8';
        $form['form[sentences][3]'] = '10';

        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/survey-completed$/', $client->getResponse()->getTargetUrl());
    }
}
