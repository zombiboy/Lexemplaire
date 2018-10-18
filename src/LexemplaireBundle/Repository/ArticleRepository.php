<?php

namespace LexemplaireBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{

	// Retourne la quantité en stock du produit demandé
	public function Disponible($id)
	{
		return $this->createQueryBuilder('l')
 
                        ->select('l.stock')
                        ->where ('l.id=:id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->getSingleScalarResult();
	}

// Vérifie l'existence du produit demandé par le client
	public function Exist($id)
	{
		return $this->createQueryBuilder('l')
 
                        ->select('count(l)')
                        ->where ('l.id=:id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->getSingleScalarResult();
	}


	// Mise à jour du stock en retranchant la quantité sortie
	public function UpdateStock($id, $n)
	{
			$query = $this->_em->createQuery('UPDATE LexemplaireBundle:Article a set a.stock = a.stock - :n WHERE a.id = :id');
				$query->setParameter('n', $n);
				$query->setParameter('id', $id);
				return $query->execute();
	}

	// Mise à jour du stock en ajoutant la quantité ajouté
	public function MiseAJour($id, $n)
	{
			$query = $this->_em->createQuery('UPDATE LexemplaireBundle:Article a set a.stock = a.stock + :n where a.libelle = :id');
				$query->setParameter('n', $n);
				$query->setParameter('id', $id);
				return $query->execute();
	}
}