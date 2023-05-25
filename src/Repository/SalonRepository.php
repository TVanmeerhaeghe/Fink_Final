<?php

namespace App\Repository;

use App\Entity\Salon;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Salon>
 *
 * @method Salon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salon[]    findAll()
 * @method Salon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Salon::class);
    }

    public function save(Salon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Salon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Méthode perso pour recherche via ville ou style
    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $data = $this->createQueryBuilder('s');
        if(!empty($searchData->q)) {
            $data = $data
                ->where('SOUNDEX(s.Ville) = SOUNDEX(:q) OR SOUNDEX(s.Style) = SOUNDEX(:q)')
                ->setParameter('q', "%{$searchData->q}%");
        }

        $data = $data
            ->getQuery()
            ->getResult();
        
        $salons = $this->paginatorInterface->paginate($data, $searchData->page, 9);

        return $salons;
    }

    //Méthode perso pour filtrer les salons par style
    public function findByStyle($selectedStyle)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.Style = :style')
            ->setParameter('style', $selectedStyle)
            ->getQuery()
            ->getResult();
    }
}
