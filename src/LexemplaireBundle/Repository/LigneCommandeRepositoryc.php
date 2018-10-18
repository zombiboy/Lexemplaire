<?php

namespace LexemplaireBundle\Repository;
use LexemplaireBundle\Entity; 

/**
 * LigneCommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LigneCommandeRepository extends \Doctrine\ORM\EntityRepository
{

	public function Price($id)
	{
		$query = $this->_em->createQuery('SELECT a.libelle as designation, l.quantiteCommande as quantite, a.prix as prixu, l.quantiteCommande * a.prix as montant FROM LexemplaireBundle\Entity\Article a, LexemplaireBundle\Entity\LigneCommande l, LexemplaireBundle\Entity\Commande c WHERE c.id = :id and l.commande = :id and a.id = l.article');
			$query->setParameter(':id', $id);
			return $query->getArrayResult();
	}


	public function Total($id)
	{
		$query = $this->_em->createQuery('SELECT sum(l.quantiteCommande * a.prix) FROM LexemplaireBundle\Entity\Article a, LexemplaireBundle\Entity\LigneCommande l, LexemplaireBundle\Entity\Commande c WHERE c.id = :id and l.commande = :id and a.id= l.article');
			$query->setParameter(':id', $id);
			return $query->getSingleScalarResult();
	}

	public function Point()
	{
		$query = $this->_em->createQuery('SELECT a.libelle as libelle,sum(l.quantiteCommande) as quantite, a.prix as prixu, sum(l.quantiteCommande)*a.prix as montant FROM LexemplaireBundle\Entity\Article a, LexemplaireBundle\Entity\LigneCommande l, LexemplaireBundle\Entity\Commande c WHERE c.id = l.commande_id and a.id = l.article_id and cast(now() as date) = cast(c.date as date) group by (a.id)');
			return $query->getArrayResult();
	}


	public function Recette($id)
	{
		$query = $this->_em->createQuery('SELECT sum(l.quantiteCommande * a.prix) FROM LexemplaireBundle\Entity\Article a, LexemplaireBundle\Entity\LigneCommande l, LexemplaireBundle\Entity\Commande c WHERE c.id = l.commande_id and a.id = l.article_id and cast(now() as date) = cast(c.date as date) group by (a.id)');
			$query->setParameter(':id', $id);
			return $query->getSingleScalarResult();
	}

}
