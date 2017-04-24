<?php

namespace IIT\AllSpeakBundle\Controller;

use IIT\AllSpeakBundle\Entity\SurveyAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IITAllSpeakBundle:Default:index.html.twig');
    }

    public function surveyAction(Request $request)
    {
        $surveyAnswer = new SurveyAnswer();

        $genderChoices = [
            'Maschio' => 'M',
            'Femmina' => 'F'
        ];
        $currentYear = date("Y");
        $minDiagnosisYear = 1980;
        $diagnosisYearChoices = range($minDiagnosisYear, $currentYear);
        $diagnosisChoices = [
            'Spinale' => 'S',
            'Bulbare' => 'B'
        ];
        $useValueAsLabel = function($value, $key, $index) {return $value;};
        $form = $this->createFormBuilder($surveyAnswer)
            ->add('gender', ChoiceType::class, [
                'label' => 'Genere',
                'choices' => $genderChoices
            ])
            ->add('birthYear', IntegerType::class, [
                'label' => 'Anno di nascita (formato YYYY, eg: 1970)'
            ])
            ->add('diagnosisDate', DateType::class, [
                'label' => 'Periodo di diagnosi',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('alsfrsr', IntegerType::class, [
                'label' => 'ALSFRS-R (min:0, max:40)'
            ])
            ->add('communicationFunction', IntegerType::class, [
                'label' => 'Funzione comunicativa (min:0, max:4)'
            ])
            ->add('diagnosis', ChoiceType::class, [
                'label' => 'Diagnosi',
                'choices' => $diagnosisChoices
            ])
            ->add('sentences', EntityType::class, [
                'label' => "Selezionare le frasi piu' importanti (min:1, max:10)",
                'class' => 'IITAllSpeakBundle:SurveySentence',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Conferma'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $surveyAnswer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($surveyAnswer);
            $em->flush();

            return $this->redirectToRoute('survey_completed');
        }

        return $this->render('IITAllSpeakBundle:Default:survey.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function surveyCompletedAction(Request $request)
    {
        $view = 'IITAllSpeakBundle:Default:surveyCompleted.html.twig';
        $redirectUrl = '/';
        return $this->renderWithRedirect($view, [], $redirectUrl);
    }

    public function adminAction(Request $request)
    {
        return $this->render('IITAllSpeakBundle:Default:admin.html.twig');
    }


    private function renderWithRedirect($view, $parameters, $redirectUrl, $seconds=3)
    {
        $response = new Response;
        $htmlContent = $this->container->get('twig')->render($view, $parameters);

        $response->headers->set('Refresh', $seconds.'; url='. $redirectUrl);
        $response->setContent($htmlContent);

        return $response;
    }
}
