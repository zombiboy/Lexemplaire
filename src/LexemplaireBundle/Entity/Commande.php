<?php

namespace LexemplaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="LexemplaireBundle\Repository\CommandeRepository")
 */
class Commande
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
    * @ORM\OneToMany(targetEntity="LexemplaireBundle\Entity\LigneCommande", mappedBy="commande", cascade={"persist", "remove"})
    */
    private $lignecommande; // Notez le « s », une commande est liée à plusieurs lignecommandes    


    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \Date $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
    * 
    * @return string Représentation d'une commande
    */
    public function __toString()
    {
        $temp=(string)$this->id;
        return $temp;
    }
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignecommandes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lignecommande
     *
     * @param \LexemplaireBundle\Entity\LigneCommande $lignecommande
     *
     * @return Commande
     */
    public function addLignecommande(\LexemplaireBundle\Entity\LigneCommande $lignecommande)
    {
        $this->lignecommandes[] = $lignecommande;
        
        $lignecommande->setCommande($this);

        return $this;
    }

    /**
     * Remove lignecommande
     *
     * @param \LexemplaireBundle\Entity\LigneCommande $lignecommande
     */
    public function removeLignecommande(\LexemplaireBundle\Entity\LigneCommande $lignecommande)
    {
        $this->lignecommandes->removeElement($lignecommande);
    }

    /**
     * Get lignecommandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignecommandes()
    {
        return $this->lignecommandes;
    }

    /**
     * Get lignecommande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignecommande()
    {
        return $this->lignecommande;
    }
}
