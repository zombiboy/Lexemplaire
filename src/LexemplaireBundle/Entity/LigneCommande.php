<?php

namespace LexemplaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCommande
 *
 * @ORM\Table(name="ligne_commande")
 * @ORM\Entity(repositoryClass="LexemplaireBundle\Repository\LigneCommandeRepository")
 */
class LigneCommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantiteCommande", type="integer", nullable=false)
     */
    private $quantiteCommande;

     /**
    * @ORM\ManyToOne(targetEntity="LexemplaireBundle\Entity\Article", inversedBy="lignessai")
    ** @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)
     *)
    */
    
    private $article;

    /**
    * @ORM\ManyToOne(targetEntity="LexemplaireBundle\Entity\Commande", inversedBy="lignecommande")
     * @ORM\JoinColumn(name="commande_id", referencedColumnName="id", nullable=false)
     *)
    */
    private $commande;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantiteCommande
     *
     * @param integer $quantiteCommande
     *
     * @return LigneCommande
     */
    public function setQuantiteCommande($quantiteCommande)
    {
        $this->quantiteCommande = $quantiteCommande;

        return $this;
    }

    /**
     * Get quantiteCommande
     *
     * @return integer
     */
    public function getQuantiteCommande()
    {
        return $this->quantiteCommande;
    }

    /**
     * Set article
     *
     * @param \LexemplaireBundle\Entity\Article $article
     *
     * @return LigneCommande
     */
    public function setArticle(\LexemplaireBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \LexemplaireBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set commande
     *
     * @param \LexemplaireBundle\Entity\Commande $commande
     *
     * @return LigneCommande
     */
    public function setCommande(\LexemplaireBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \LexemplaireBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
