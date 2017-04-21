<?php

namespace IIT\AllSpeakBundle\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use IIT\AllSpeakBundle\DataFixtures\ORM\LoadSurveySentences;

class DefaultControllerTest extends WebTestCase
{
    private $container;
    private $em;

    private function getSurveyTakerClient() {
        $surveyTakerPassword = $this->container->getParameter('surveytaker_password');

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'surveytaker',
            'PHP_AUTH_PW'   => $surveyTakerPassword,
        ]);

        return $client;
    }

    private function selectChoices(array $formField, $indexes) {
        foreach($indexes as $i)
            $formField[$i]->tick();
    }

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->em = $this->container
            ->get('doctrine')
            ->getManager();

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
        $fixture = new LoadSurveySentences();
        $fixture->load($this->em);
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

    /**
     * @depends testSurveyAuthenticated
     */
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

        $surveyAnswers = $this->em->getRepository('IITAllSpeakBundle:SurveyAnswer')->findAll();
        $this->assertCount(0, $surveyAnswers);
    }

    /**
     * @depends testSurveyAuthenticated
     */
    public function testSurveySubmitValid()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/survey');

        $form = $crawler->selectButton('Conferma')->form();
        $form['form[gender]'] = 'F';
        $form['form[birthYear]'] = '1946';
        $form['form[diagnosisDate]'] = '2005-04-01';
        $form['form[alsfrsr]'] = '34';
        $form['form[communicationFunction]'] = '3';
        $form['form[diagnosis]'] = 'S';
        $this->selectChoices($form['form[sentences]'], [0,1,2]);
        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/survey-completed$/', $client->getResponse()->getTargetUrl());

        $surveyAnswers = $this->em->getRepository('IITAllSpeakBundle:SurveyAnswer')->findAll();
        $this->assertCount(1, $surveyAnswers);
    }
}
