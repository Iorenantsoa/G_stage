<?php

namespace App\Repository;

use App\Entity\Stage;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

   /**
    * @return User[] Returns an array of User objects
    */
   public function findMyEncadrements($myId): array
   {
       return $this->createQueryBuilder('u')
           ->andWhere('u.user = :myId')
           ->setParameter('myId', $myId)
           ->getQuery()
           ->getResult()
       ;
   }
   /**
    * @return User[] Returns an array of User objects
    */
    public function findStageANoter($id): array
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->Join('u.stage' , 's')
            ->where("s.validation IS NOT NULL ")
            ->andWhere("u.user = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
    * @return User[] Returns an array of User objects
    */
    public function findUserHaveEncadreur(): array
    {
        return $this->createQueryBuilder('u')
            ->select("u")
            ->where("u.user IS NOT NULL")
            ->getQuery()
            ->getResult()
        ;
    }
    /**
    * @return User[] Returns an array of User objects
    */
    public function findUserDontHaveEncadreur($role): array
    {
        return $this->createQueryBuilder('u')
            ->where("u.user IS NULL")   
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role',"%\"$role\"%")
            ->getQuery()
            ->getResult()
        ;
    }
    /**
    * @return User[] Returns an array of User objects
    */
    public function findUserDontHaveRapport($role): array
    {
        return $this->createQueryBuilder('u')
            ->where("u.rapport IS NULL") 
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role',"%\"$role\"%")  
            ->getQuery()
            ->getResult()
        ;
    }
    /**
    * @return User[] Returns an array of User objects
    */
    public function findUserNote(): array
    {
        return $this->createQueryBuilder('u')
            ->where("u.note IS NOT NULL") 
            ->getQuery()
            ->getResult()
        ;
    }
    
     /**
    * @return User[] Returns an array of User objects
    */
    public function findNbEtudiant($role): array
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)') 
            ->where('u.roles LIKE :role') 
            ->setParameter('role',"%\"$role\"%")  
            ->getQuery()
            ->getScalarResult()
        ;
    }



//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
