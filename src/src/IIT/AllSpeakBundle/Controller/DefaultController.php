<?php

namespace IIT\AllSpeakBundle\Controller;

use IIT\AllSpeakBundle\Entity\SurveyAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $sentencesRepository = $this->getDoctrine()->getRepository('IITAllSpeakBundle:SurveySentence');

        $genderChoices = [
            'Maschio' => 'M',
            'Femmina' => 'F'
        ];
        $surveySentences = $sentencesRepository->findAll();
        $currentYear = date("Y");
        $minBirthYear = 1940;
        $minDiagnosisYear = 1980;
        $birthYearChoices = range($minBirthYear, $currentYear);
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
            ->add('birthYear', ChoiceType::class, [
                'label' => 'Anno di nascita',
                'choices' => $birthYearChoices,
                'choice_label' => $useValueAsLabel
            ])
            ->add('diagnosisYear', ChoiceType::class, [
                'label' => 'Anno di diagnosi',
                'choices' => $diagnosisYearChoices,
                'choice_label' => $useValueAsLabel
            ])
            ->add('alsfrsr', IntegerType::class, [
                'label' => 'ALSFR-R'
            ])
            ->add('verbalScore', IntegerType ::class, [
                'label' => 'Score verbale'
            ])
            ->add('diagnosis', ChoiceType::class, [
                'label' => 'Diagnosi',
                'choices' => $diagnosisChoices
            ])
            ->add('sentences', ChoiceType::class, [
                'label' => "Selezionare le frasi piu' importanti",
                'multiple' => true,
                'expanded' => true,
                'choices' => $surveySentences,
                'choice_label' => 'getText',
                'choice_value' => 'getId'
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

    private function renderWithRedirect($view, $parameters, $redirectUrl, $seconds=3)
    {
        $response = new Response;
        $htmlContent = $this->container->get('twig')->render($view, $parameters);

        $response->headers->set('Refresh', $seconds.'; url='. $redirectUrl);
        $response->setContent($htmlContent);

        return $response;
    }
}
