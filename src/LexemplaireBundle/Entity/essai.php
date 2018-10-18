<?php

namespace LexemplaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * essai
 *
 * @ORM\Table(name="essai")
 * @ORM\Entity(repositoryClass="LexemplaireBundle\Repository\essaiRepository")
 */
class essai
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
    * @ORM\OneToMany(targetEntity="LexemplaireBundle\Entity\LigneCommande", mappedBy="essai", cascade={"persist", "remove"})
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
        $this->lignessai = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lignessai
     *
     * @param \LexemplaireBundle\Entity\LigneCommande $lignessai
     *
     * @return essai
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
