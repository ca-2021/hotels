<?php


namespace App\Dto\Response;

/**
 * Class StatisticsResponseDto
 * @package App\Dto\Response
 */
class StatisticsResponseDto
{
    public int $review_count;
    public float $average_score;
    public string $date_group;
}