<?php

namespace IIT\AllSpeakBundle\Controller;

use IIT\AllSpeakBundle\Entity\SurveySentence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Surveysentence controller.
 *
 */
class SurveySentenceController extends Controller
{
    /**
     * Lists all surveySentence entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $surveySentences = $em->getRepository('IITAllSpeakBundle:SurveySentence')->findAll();

        return $this->render('IITAllSpeakBundle:surveySentence:index.html.twig', array(
            'surveySentences' => $surveySentences
        ));
    }

    /**
     * Creates a new surveySentence entity.
     *
     */
    public function newAction(Request $request)
    {
        $surveySentence = new Surveysentence();
        $form = $this->createForm('IIT\AllSpeakBundle\Form\SurveySentenceType', $surveySentence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($surveySentence);
            $em->flush($surveySentence);

            return $this->redirectToRoute('surveysentence_index');
        }

        return $this->render('IITAllSpeakBundle:surveySentence:new.html.twig', array(
            'surveySentence' => $surveySentence,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing surveySentence entity.
     *
     */
    public function editAction(Request $request, SurveySentence $surveySentence)
    {
        $deleteForm = $this->createDeleteForm($surveySentence);
        $editForm = $this->createForm('IIT\AllSpeakBundle\Form\SurveySentenceType', $surveySentence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('surveysentence_index');
        }

        return $this->render('IITAllSpeakBundle:surveySentence:edit.html.twig', array(
            'surveySentence' => $surveySentence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a surveySentence entity.
     *
     */
    public function deleteAction(Request $request, SurveySentence $surveySentence)
    {
        $form = $this->createDeleteForm($surveySentence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($surveySentence);
            $em->flush($surveySentence);
        }

        return $this->redirectToRoute('surveysentence_index');
    }

    /**
     * Creates a form to delete a surveySentence entity.
     *
     * @param SurveySentence $surveySentence The surveySentence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SurveySentence $surveySentence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('surveysentence_delete', array('id' => $surveySentence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
