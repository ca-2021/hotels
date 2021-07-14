<?php

namespace App\Repository;


use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    private HotelRepository $hotelRepository;

    public function __construct(ManagerRegistry $registry, HotelRepository $hotelRepository)
    {
        parent::__construct($registry, Review::class);
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * @return array
     */
    public function getStats($hotelId, $fromDate, $toDate): array
    {
        $hotel = $this->hotelRepository->findByID($hotelId);

        return $this->createQueryBuilder('q')
            ->select('count(q) as review_count')
            ->addSelect('avg(q.score) as average_score')
            ->addSelect('DATE_FORMAT(q.created_date, :date_format) as date_group')
            ->andWhere('q.created_date BETWEEN :date_from and :date_to')
            ->andWhere('q.hotel = :hotel')
            ->setParameters([
                'date_from' => $fromDate,
                'date_to' => $toDate,
                'hotel' => $hotel,
                'date_format' => $this->getGrouping($fromDate, $toDate),
            ])
            ->groupBy('date_group')
            ->orderBy('date_group')
            ->getQuery()
            ->getResult();

    }

    protected function getGrouping($fromDate, $toDate): string
    {
        $datediff = (strtotime($toDate) - strtotime($fromDate))/ (60 * 60 * 24);

        if ($datediff <= 29) {
            return '%Y-%m-%d';
        }
        elseif ($datediff <= 89) {
            return '%Y/%u';
        }
        return '%Y-%m';
    }

}
