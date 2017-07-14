<?php

namespace IIT\AllSpeakBundle\Controller;

use IIT\AllSpeakBundle\Entity\NewsPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Newspost controller.
 *
 */
class NewsPostController extends Controller
{
    /**
     * Lists all newsPost entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsPosts = $em->getRepository('IITAllSpeakBundle:NewsPost')->findAll();

        return $this->render('IITAllSpeakBundle:NewsPost:index.html.twig', array(
            'newsPosts' => $newsPosts,
        ));
    }

    /**
     * Creates a new newsPost entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsPost = new Newspost();
        $newsPost->setTs(new \DateTime());

        $form = $this->createForm('IIT\AllSpeakBundle\Form\NewsPostType', $newsPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsPost);
            $em->flush($newsPost);

            return $this->redirectToRoute('newspost_index');
        }

        return $this->render('IITAllSpeakBundle:NewsPost:new.html.twig', array(
            'newsPost' => $newsPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsPost entity.
     *
     */
    public function showAction(NewsPost $newsPost)
    {

        return $this->render('IITAllSpeakBundle:NewsPost:show.html.twig', array(
            'newsPost' => $newsPost
        ));
    }

    /**
     * Displays a form to edit an existing newsPost entity.
     *
     */
    public function editAction(Request $request, NewsPost $newsPost)
    {
        $deleteForm = $this->createDeleteForm($newsPost);
        $editForm = $this->createForm('IIT\AllSpeakBundle\Form\NewsPostType', $newsPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newspost_index');
        }

        return $this->render('IITAllSpeakBundle:NewsPost:edit.html.twig', array(
            'newsPost' => $newsPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a newsPost entity.
     *
     */
    public function deleteAction(Request $request, NewsPost $newsPost)
    {
        $form = $this->createDeleteForm($newsPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsPost);
            $em->flush($newsPost);
        }

        return $this->redirectToRoute('newspost_index');
    }

    /**
     * Creates a form to delete a newsPost entity.
     *
     * @param NewsPost $newsPost The newsPost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NewsPost $newsPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newspost_delete', array('id' => $newsPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
