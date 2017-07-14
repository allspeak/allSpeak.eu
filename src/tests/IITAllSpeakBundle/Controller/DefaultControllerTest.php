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

    private function getAdminClient() {
        $adminPassword = $this->container->getParameter('admin_password');

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => $adminPassword,
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

        $crawler = $client->request('GET', '/it/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('.index')->count());
    }

    public function testSurveyUnauthenticated()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/it/survey');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/survey_login$/', $client->getResponse()->getTargetUrl());
    }

    public function testSurveyAuthenticated()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/it/survey');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('form')->count());
    }

    public function testAdminUnauthenticated()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/login$/', $client->getResponse()->getTargetUrl());

        $crawler = $client->request('GET', '/admin_survey_summary');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/login$/', $client->getResponse()->getTargetUrl());
    }

    public function testAdminAuthenticated()
    {
        $client = $this->getAdminClient();

        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h2')->count());

        $crawler = $client->request('GET', '/admin_survey_summary');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testSurveyAuthenticated
     */
    public function testSurveySubmitNotValid()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/it/survey');

        $form = $crawler->selectButton('Invia')->form();
        $form['form[gender]'] = 'M';

        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/\/survey$/', $crawler->getUri());
        $this->assertGreaterThan(0, $crawler->filter('.has-error')->count());

        $surveyAnswers = $this->em->getRepository('IITAllSpeakBundle:SurveyAnswer')->findAll();
        $this->assertCount(0, $surveyAnswers);

        $adminClient = $this->getAdminClient();

        $crawler = $adminClient->request('GET', '/admin_survey_summary');

        $this->assertEquals(200, $adminClient->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('.summary')->count());
    }

    /**
     * @depends testSurveyAuthenticated
     */
    public function testSurveySubmitValid()
    {
        $client = $this->getSurveyTakerClient();

        $crawler = $client->request('GET', '/it/survey');

        $form = $crawler->selectButton('Invia')->form();
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

        $adminClient = $this->getAdminClient();

        $crawler = $adminClient->request('GET', '/admin_survey_summary');

        $averageBirthYear = 1946;
        $averageAge = date("Y")-$averageBirthYear;
        $averageDiagnosisDate = new \DateTime('2005-04-01');
        $averageTimeSinceDiagnosis = (new \DateTime())->diff($averageDiagnosisDate);
        $averageTimeSinceDiagnosisFormatted = $averageTimeSinceDiagnosis->format('%y years, %m months, %d days');
        $this->assertEquals(200, $adminClient->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('.summary')->count());
        $this->assertEquals(1, $crawler->filter('.answer-num')->first()->text());
        $this->assertEquals(0, $crawler->filter('.male-ratio')->first()->text());
        $this->assertEquals($averageAge, $crawler->filter('.average-age')->first()->text());
        $this->assertEquals($averageTimeSinceDiagnosisFormatted, trim($crawler->filter('.since-diagnosis')->first()->text()));
    }

}
