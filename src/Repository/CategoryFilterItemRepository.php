<?php

namespace App\Repository;

use App\Entity\CategoryFilterItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryFilterItem>
 *
 * @method CategoryFilterItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryFilterItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryFilterItem[]    findAll()
 * @method CategoryFilterItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryFilterItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryFilterItem::class);
    }

    public function add(CategoryFilterItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryFilterItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CategoryFilterItem[] Returns an array of CategoryFilterItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryFilterItem
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
