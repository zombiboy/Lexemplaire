<?php

namespace LexemplaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }

    /**
     * @Route("/generate_pdf")
     */
    public function generatePdfAction()
    {
    	$vars = "72743507";
        //return $this->render('LexemplaireBundle:Default:index.html.twig');

        $html = $this->renderView('LexemplaireBundle:Default:document.html.twig');

        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html),200,
    array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="file.pdf"'));
    }


    /**
     * @Route("/look-pdf")
     */
    public function lookPdfAction()
    {
        $vars = "72743507";
        return $this->render('LexemplaireBundle:Default:document.html.twig');     
    }

    /**
     * @Route("/direct")
     */
    public function direct()
    {
       
       $handle = printer_open();
       printer_write($handle, "Texte à imprimer");
       printer_close($handle); 
    }

}
