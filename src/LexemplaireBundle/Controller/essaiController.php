<?php

namespace LexemplaireBundle\Controller;

use LexemplaireBundle\Entity\essai;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Essai controller.
 *
 * @Route("essai")
 */
class essaiController extends Controller
{
    /**
     * Lists all essai entities.
     *
     * @Route("/", name="essai_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $essais = $em->getRepository('LexemplaireBundle:essai')->findAll();

        return $this->render('essai/index.html.twig', array(
            'essais' => $essais,
        ));
    }

    /**
     * Creates a new essai entity.
     *
     * @Route("/new", name="essai_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $essai = new Essai();
        $form = $this->createForm('LexemplaireBundle\Form\essaiType', $essai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($essai);
            $em->flush($essai);

            return $this->redirectToRoute('essai_show', array('id' => $essai->getId()));
        }

        return $this->render('essai/new.html.twig', array(
            'essai' => $essai,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a essai entity.
     *
     * @Route("/{id}", name="essai_show")
     * @Method("GET")
     */
    public function showAction(essai $essai)
    {
        $deleteForm = $this->createDeleteForm($essai);

        return $this->render('essai/show.html.twig', array(
            'essai' => $essai,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing essai entity.
     *
     * @Route("/{id}/edit", name="essai_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, essai $essai)
    {
        $deleteForm = $this->createDeleteForm($essai);
        $editForm = $this->createForm('LexemplaireBundle\Form\essaiType', $essai);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('essai_edit', array('id' => $essai->getId()));
        }

        return $this->render('essai/edit.html.twig', array(
            'essai' => $essai,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a essai entity.
     *
     * @Route("/{id}", name="essai_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, essai $essai)
    {
        $form = $this->createDeleteForm($essai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($essai);
            $em->flush($essai);
        }

        return $this->redirectToRoute('essai_index');
    }

    /**
     * Creates a form to delete a essai entity.
     *
     * @param essai $essai The essai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(essai $essai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('essai_delete', array('id' => $essai->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
