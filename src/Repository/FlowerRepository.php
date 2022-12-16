<?php

namespace App\Repository;

use App\Entity\Flower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flower>
 *
 * @method Flower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flower[]    findAll()
 * @method Flower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flower::class);
    }

    public function save(Flower $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Flower $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Flower[] Returns an array of Flower objects in alphabetical order
    */
    public function findByAlphabeticalOrder(): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string $search
     * @return array of Flower objects : results in the DB of the search via the searchbar
     */
    public function searchFlower(string $search): array
    {
        $db = $this->createQueryBuilder('flower');

        $query = $db->select('flower')
            ->where('flower.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery();
        return $query->getResult();
    }

    /**
     * @param string $categorySelected
     * @return array of Flower objects : results in the DB of the search via the select
     */
    public function selectCategory(string $categorySelected): array
    {
        return $this->getEntityManager()->createQuery(
            'SELECT f FROM App\Entity\Flower f
                JOIN f.categories c
                WHERE c.name = :category'
            )
            ->setParameter('category', $categorySelected)
            ->getResult() ;
    }



//    /**
//     * @return Flower[] Returns an array of Flower objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Flower
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
