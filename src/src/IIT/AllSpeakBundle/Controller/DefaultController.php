<?php

namespace IIT\AllSpeakBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IITAllSpeakBundle:Default:index.html.twig');
    }
    public function surveyAction()
    {
        return $this->render('IITAllSpeakBundle:Default:survey.html.twig');
    }
}
