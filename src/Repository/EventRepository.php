<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Cette fonction permet la recherche d'evenements
     * @return Evenement[]
     */
    public function findAllBySearch(EventSearch $recherche)
    {
        $query = $this->findAll();

        //Si c'est le lieux qui est cherché
        if($recherche->getLieux())
        {
            return $this->createQueryBuilder('e')
            ->andWhere('e.lieux=:val')
            ->setParameter('val',$recherche->getLieux())
            ->orderBy('e.date','ASC')
            ->getQuery()
            ->getResult();
        }
        //Si c'est le type qui est cherché 
        elseif($recherche->getType()) 
        {
            return $this->createQueryBuilder('e')
            ->andWhere('e.type=:val')
            ->setParameter('val',$recherche->getType())
            ->orderBy('e.date','ASC')
            ->getQuery()
            ->getResult();
        }
        //Si les deux sont cherchés
        elseif($recherche->getType() && $recherche->getLieux())
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.type=:typ AND e.lieux=:lie')
                ->setParameters(array('typ'=>$recherche->getType(),'lie'=>$recherche->getLieux()))
                ->orderBy('e.date','ASC')
                ->getQuery()
                ->getResult();
        }
        //Si aucune recherche n'est demandé (affiche tout)
        else{
            return $query;
        }
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
