<?php

namespace LexemplaireBundle\Controller;

use LexemplaireBundle\Entity\MiseAJour;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Miseajour controller.
 *
 * @Route("miseajour")
 */
class MiseAJourController extends Controller
{
    /**
     * Lists all miseAJour entities.
     *
     * @Route("/", name="miseajour_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $miseAJours = $em->getRepository('LexemplaireBundle:MiseAJour')->findAll();

        return $this->render('miseajour/index.html.twig', array(
            'miseAJours' => $miseAJours,
        ));
    }

    /**
     * Creates a new miseAJour entity.
     *
     * @Route("/new", name="miseajour_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $miseAJour = new Miseajour();
        $form = $this->createForm('LexemplaireBundle\Form\MiseAJourType', $miseAJour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $miseAJour->setDate(new \Datetime());
            $em->persist($miseAJour);
            $em->flush($miseAJour);

            foreach ($form->get('article')->getData() as $ac) 
            {
                $id=$ac->getLibelle();
                $stock=$ac->getStock();
                $n = $em->getRepository('LexemplaireBundle:Article')->MiseAJour($id,$stock);
            }

            return $this->redirectToRoute('article_index');
        }

        return $this->render('miseajour/new.html.twig', array(
            'miseAJour' => $miseAJour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a miseAJour entity.
     *
     * @Route("/{id}", name="miseajour_show")
     * @Method("GET")
     */
    public function showAction(MiseAJour $miseAJour)
    {
        $deleteForm = $this->createDeleteForm($miseAJour);

        return $this->render('miseajour/show.html.twig', array(
            'miseAJour' => $miseAJour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing miseAJour entity.
     *
     * @Route("/{id}/edit", name="miseajour_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MiseAJour $miseAJour)
    {
        $deleteForm = $this->createDeleteForm($miseAJour);
        $editForm = $this->createForm('LexemplaireBundle\Form\MiseAJourType', $miseAJour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('miseajour_edit', array('id' => $miseAJour->getId()));
        }

        return $this->render('miseajour/edit.html.twig', array(
            'miseAJour' => $miseAJour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a miseAJour entity.
     *
     * @Route("/{id}", name="miseajour_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MiseAJour $miseAJour)
    {
        $form = $this->createDeleteForm($miseAJour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($miseAJour);
            $em->flush($miseAJour);
        }

        return $this->redirectToRoute('miseajour_index');
    }

    /**
     * Creates a form to delete a miseAJour entity.
     *
     * @param MiseAJour $miseAJour The miseAJour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MiseAJour $miseAJour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('miseajour_delete', array('id' => $miseAJour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
