<?php

namespace LexemplaireBundle\Controller;

use LexemplaireBundle\Entity\Facture;
use LexemplaireBundle\Entity\Commande;
use LexemplaireBundle\Entity\LigneCommande;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;



/**
 * Miseajour controller.
 *
 * @Route("point")
 */
class PointController extends Controller
{
    
    /**
     * Creates a new miseAJour entity.
     *
     * @Route("/jour", name="point_jour")
     * @Method({"GET", "POST"})
     */
    public function jourAction(Request $request)
    {
        $factures=new Facture();
        $em = $this->getDoctrine()->getManager();
        $temp= new \Datetime();
        $temp=$temp->format('Y\-m\-d\ ');
        $factures = $em->getRepository('LexemplaireBundle:LigneCommande')->Point($temp);

        //Calcul du total
        $total= $em->getRepository('LexemplaireBundle:LigneCommande')->Recette($temp);
        return $this->render('facture/new.html.twig', array(
            'factures' => $factures, 'fac' => $total ,
        ));
        
    }


    /**
     * Creates a new miseAJour entity.
     *
     * @Route("/periode", name="point_periode")
     * @Method({"GET", "POST"})
     */
    public function periodeAction(Request $request)
    {
        $factures=new Facture();
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder()
                     ->add('min',  DateType::class)
                     ->add('max', DateType::class)
                     ->getForm();
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST' && $form->isValid()) 
        {
            $min = $form->get('min')->getData();
            $max = $form->get('max')->getData();
            $min=$min->format('Y\-m\-d\ ');
            $max=$max->format('Y\-m\-d\ ');
            $factures = $em->getRepository('LexemplaireBundle:LigneCommande')->PointPeriode($min, $max);

            //Calcul du total
            $total= $em->getRepository('LexemplaireBundle:LigneCommande')->RecettePeriode($min, $max);
          
           return $this->render('facture/new.html.twig', array(
            'factures' => $factures, 'fac' => $total ,
        ));
        }

        return $this->render('facture/point.html.twig', array(
      'form' => $form->createView(),
    ));
        
    }
}
