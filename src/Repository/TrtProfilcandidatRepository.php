<?php

namespace App\Repository;

use App\Entity\TrtProfilcandidat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrtProfilcandidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrtProfilcandidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrtProfilcandidat[]    findAll()
 * @method TrtProfilcandidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrtProfilcandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrtProfilcandidat::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TrtProfilcandidat $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TrtProfilcandidat $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TrtProfilcandidat[] Returns an array of TrtProfilcandidat objects
    //  */

    public function findProfilByUser($user)
    {
        return $this->createQueryBuilder('t')
            ->from('App\Entity\TrtUser', 'u')
            ->select('u , t')
            ->andWhere('t.idUser = u.id')
            ->andWhere('t.idUser = :val')
            ->setParameter('val', $user)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }



    public function findOneByUser($value): ?TrtProfilcandidat
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.idUser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
