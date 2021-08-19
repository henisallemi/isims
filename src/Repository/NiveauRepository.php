<?php

namespace App\Repository;

use App\Entity\Niveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Niveau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Niveau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Niveau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Niveau::class);
    }

    public function findAll():array
    {
        return $this->findBy([], ['ordre' => 'ASC']);
    }

    public function getNiveauxArray():array
    {
        $niveaux = $this->findAll();
        $choixNiveaux = array();
        foreach ($niveaux as $niveau) {
            $choixNiveaux[$niveau->getNiveauName()] = $niveau->getId();
        }
        return $choixNiveaux;
    }

        // /**
        //  * @return Niveau[] Returns an array of Niveau objects
        //  */
        /*
        public function findByExampleField($value)
        {
            return $this->createQueryBuilder('n')
                ->andWhere('n.exampleField = :val')
                ->setParameter('val', $value)
                ->orderBy('n.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
        */

        /*
        public function findOneBySomeField($value): ?Niveau
        {
            return $this->createQueryBuilder('n')
                ->andWhere('n.exampleField = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        */
}