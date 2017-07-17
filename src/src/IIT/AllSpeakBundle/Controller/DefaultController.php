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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
        $newsPosts = $em->getRepository('IITAllSpeakBundle:NewsPost')->findAll(5);

        return $this->render("IITAllSpeakBundle:Default:index-$locale.html.twig", array(
            'newsPosts' => $newsPosts,
        ));
    }
    public function detailsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();

        return $this->render("IITAllSpeakBundle:Default:details-$locale.html.twig");
    }

    public function surveyAction(Request $request)
    {
        $surveyAnswer = new SurveyAnswer();

        $genderChoices = [
            'Male' => 'M',
            'Female' => 'F'
        ];
        $currentYear = date("Y");
        $minDiagnosisYear = 1980;
        $diagnosisYearChoices = range($minDiagnosisYear, $currentYear);
        $diagnosisChoices = [
            'Spinal' => 'S',
            'Bulbar' => 'B'
        ];
        $useValueAsLabel = function ($value, $key, $index) {
            return $value;
        };
        $form = $this->createFormBuilder($surveyAnswer)
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => $genderChoices
            ])
            ->add('birthYear', IntegerType::class, [
                'label' => "SurveyForm.BirthYear"
            ])
            ->add('diagnosisDate', DateType::class, [
                'label' => 'DiagnosisDate',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('alsfrsr', IntegerType::class, [
                'label' => 'SurveyForm.ALSFRSR'
            ])
            ->add('communicationFunction', IntegerType::class, [
                'label' => 'SurveyForm.CommunicativeFunction'
            ])
            ->add('diagnosis', ChoiceType::class, [
                'label' => 'Diagnosis',
                'choices' => $diagnosisChoices
            ])
            ->add('sentences', EntityType::class, [
                'label' => "SurveyForm.Sentences",
                'class' => 'IITAllSpeakBundle:SurveySentence',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'SurveyForm.Submit'
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

    public function surveySummaryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $surveySummary = $em->getRepository('IITAllSpeakBundle:SurveyAnswer')->getSurveySummary();

        return $this->render('IITAllSpeakBundle:Default:surveySummary.html.twig', [
            'surveySummary' => $surveySummary,
        ]);
    }

    public function adminAction(Request $request)
    {
        return $this->render('IITAllSpeakBundle:Default:admin.html.twig');
    }


    private function renderWithRedirect($view, $parameters, $redirectUrl, $seconds = 3)
    {
        $response = new Response;
        $htmlContent = $this->container->get('twig')->render($view, $parameters);

        $response->headers->set('Refresh', $seconds . '; url=' . $redirectUrl);
        $response->setContent($htmlContent);

        return $response;
    }
}
