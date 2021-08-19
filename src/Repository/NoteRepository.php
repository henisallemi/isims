<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function findByMatiere($matiere, $anneeScolaire){
        return $this->findBy(['matiere'=>$matiere, 'anneScolaire'=>$anneeScolaire]);
    }

    public function getHistorique($historiqueSelection, $semestre){
        $query = $this->createQueryBuilder('n')
            ->Join('n.matiere', 'm', Join::WITH, 'm.semestre = ?1 ')
            ->where(' n.etudiant = ?2 and n.anneScolaire = ?3 ')
            ->setParameter(1, $semestre)
            ->setParameter(2, $historiqueSelection->getTmpEtudiant())
            ->setParameter(3, $historiqueSelection->getAnnee());
        return $query->getQuery()->getResult();
    }

    public function findAnnneByEtudiant($etudiant){

        $query = $this->createQueryBuilder('n')
            ->select('n.anneScolaire')
            ->where('n.etudiant = ?1')
            ->distinct()
            ->setParameter(1, $etudiant->getId());
        return $query->getQuery()->getResult();
    }


    public function getNotes($matiereSelection){
        $query = $this->createQueryBuilder('n')
            ->where('n.anneScolaire = ?1 and n.matiere = ?2')
            ->setParameter(1, $matiereSelection->getAnnee())
            ->setParameter(2, $matiereSelection->getMatiere());
        return $query->getQuery()->getResult();
    }

        // /**
    //  * @return Note[] Returns an array of Note objects
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
    public function findOneBySomeField($value): ?Note
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