<?php

namespace LexemplaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="LexemplaireBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=30, unique=true)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
    * @ORM\OneToMany(targetEntity="LexemplaireBundle\Entity\LigneCommande", mappedBy="article", cascade={"persist", "remove"})
    */
    private $lignessai; // Notez le « s », une commande est liée à plusieurs lignecommandes   



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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Article
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }
    

    /**
    * 
    * @return string Représentation d'une commande
    */
    public function __toString()
    {
        
        return $this->libelle;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignessai = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lignessai
     *
     * @param \LexemplaireBundle\Entity\LigneCommande $lignessai
     *
     * @return Article
     */
    public function addLignessai(\LexemplaireBundle\Entity\LigneCommande $lignessai)
    {
        $this->lignessai[] = $lignessai;

        return $this;
    }

    /**
     * Remove lignessai
     *
     * @param \LexemplaireBundle\Entity\LigneCommande $lignessai
     */
    public function removeLignessai(\LexemplaireBundle\Entity\LigneCommande $lignessai)
    {
        $this->lignessai->removeElement($lignessai);
    }

    /**
     * Get lignessai
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignessai()
    {
        return $this->lignessai;
    }
}
