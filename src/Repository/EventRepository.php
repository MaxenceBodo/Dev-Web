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
     * @return Evenement[]
     */
    public function findAllBySearch(EventSearch $recherche)
    {
        $query = $this->findAll();

        if($recherche->getLieux())
        {
            return $this->createQueryBuilder('e')
            ->andWhere('e.lieux=:val')
            ->setParameter('val',$recherche->getLieux())
            ->orderBy('e.date','ASC')
            ->getQuery()
            ->getResult();
        } elseif($recherche->getType()) 
        {
            return $this->createQueryBuilder('e')
            ->andWhere('e.type=:val')
            ->setParameter('val',$recherche->getType())
            ->orderBy('e.date','ASC')
            ->getQuery()
            ->getResult();
        }else{
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
