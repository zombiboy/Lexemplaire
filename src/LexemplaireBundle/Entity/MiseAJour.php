<?php

namespace LexemplaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="mise_a_jour")
 * @ORM\Entity(repositoryClass="LexemplaireBundle\Repository\MiseAJourRepository")
 */
class MiseAJour
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
    * @ORM\ManyToMany(targetEntity="LexemplaireBundle\Entity\Article")
    */
    private $article; 

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
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }


    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->article = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add Article
     *
     * @param \LexemplaireBundle\Entity\Article $article
     *
     * @return Article
     */
    public function addArticle(\LexemplaireBundle\Entity\Article $article)
    {
        $this->articles[] = $article;
        return $this;
    }

    /**
     * Remove Article
     *
     * @param \LexemplaireBundle\Entity\Article $article
     */
    public function removeArticle(\LexemplaireBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get lignecommandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Get Article
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->Article;
    }

}
