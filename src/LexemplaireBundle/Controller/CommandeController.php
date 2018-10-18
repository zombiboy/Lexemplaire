<?php

namespace LexemplaireBundle\Controller;

use LexemplaireBundle\Entity\Commande;
use LexemplaireBundle\Entity\Article;
use LexemplaireBundle\Entity\LigneCommande;
use LexemplaireBundle\Entity\Facture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 * @Route("commande")
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @Route("/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('LexemplaireBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new commande entity.
     *
     * @Route("/new", name="commande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $lignecommande=new LigneCommande();
        $facture=new Facture();

        $form = $this->createForm('LexemplaireBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $em = $this->getDoctrine()->getManager();
            $commande->setDate(new \Datetime());
            $em->persist($commande);
            $em->flush();
            
            // Enregistrement des lignes de commandes dans la base de données

            foreach ($form->get('lignecommande')->getData() as $ac) 
            {
                // Vérification de l'exactitude du nom du produit demandé
                $m = $em->getRepository('LexemplaireBundle:Article')->Exist($ac->getArticle());
           
                if($m == 1)
                {

                    //On vérifie les des contraintes de capacité;La commande peut-elle etre satisfaite?
                    $n = $em->getRepository('LexemplaireBundle:Article')->Disponible($ac->getArticle());
                   if($n >= $ac->getQuantiteCommande())
                    {
                        $ac->setCommande($commande);
                        $em->persist($ac);

                        // Mise à jour de la quantité en stock

                        $n = $em->getRepository('LexemplaireBundle:Article')->UpdateStock($ac->getArticle(), $ac->getQuantiteCommande());
                    
                    }
                    else
                    {
                        return $this->render('commande/new.html.twig', array(
                            'commande' => $commande,
                            'form' => $form->createView(),
                        ));
                    } 
                }
                else
                {
                        return $this->render('commande/new.html.twig', array(
                            'commande' => $commande,
                            'form' => $form->createView(),
                        ));
                }
                
            }
            $em->flush();
            
            //Recupération des lignes de commandes pour l'établissement de la facture

            $em = $this->getDoctrine()->getManager();
            $facture = $em->getRepository('LexemplaireBundle:LigneCommande')->Price($commande->getId());

            //Calcul du total
            $total= $em->getRepository('LexemplaireBundle:LigneCommande')->Total($commande->getId());
//
            
            return $this->render('facture/index.html.twig', array(
            'factures' => $facture, 'fac' => $total, 'num' =>$commande->getId(), 'commande'=>$commande,
            ));

        }

        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     * @Route("/{id}", name="commande_show")
     * @Method("GET")
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/{id}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('LexemplaireBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     * @Route("/{id}", name="commande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush($commande);
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
