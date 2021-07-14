<?php

namespace App\Controller;

use App\Dto\Response\StatisticsResponseDto;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class OvertimeStatsController extends AbstractController
{
    private ReviewRepository $reviewRepository;
    private DenormalizerInterface $denormalizer;

    /**
     * OvertimeStatsController constructor.
     * @param ReviewRepository $reviewRepository
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(ReviewRepository $reviewRepository, DenormalizerInterface $denormalizer)
    {
        $this->reviewRepository = $reviewRepository;
        $this->denormalizer = $denormalizer;
    }


    /**
     * @Route("/api/stats/{hotelId<\d+>}/{fromDate<\d\d\d\d-\d\d-\d\d>}/{toDate<\d\d\d\d-\d\d-\d\d>}", methods={"GET"})
     */
    public function getStats($hotelId, $fromDate, $toDate): Response
    {

        $content = $this->reviewRepository->getStats($hotelId, $fromDate, $toDate);

        $dtos = $this->denormalizer->denormalize($content, StatisticsResponseDto::class.'[]', null, [
            ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true
        ]);

        return $this->json($dtos);
    }



}
