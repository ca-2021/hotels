<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Carbon\Carbon;

class ReviewFixtures extends BaseFixture implements DependentFixtureInterface
{
    const RECORDS_NR = 100000;
    const MIN_SCORE = 1;
    const MAX_SCORE = 10;
    const TO_ADD_REFERENCE = false;
    const YEARS_SPAN = 2;

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Review::class, self::RECORDS_NR, self::TO_ADD_REFERENCE, function(Review $review, $count) {
            $startDate = Carbon::now()->subDay()->timestamp;
            $endDate   = Carbon::now()->subYears(self::YEARS_SPAN)->timestamp;
            $randomDate = Carbon::createFromTimestamp(rand($endDate, $startDate));
            /** @var Hotel $hotel */
            $hotel = $this->getReference(Hotel::class.'_'.rand(0, HotelFixtures::RECORDS_NR-1));

            $review->setScore(rand(self::MIN_SCORE,self::MAX_SCORE));
            $review->setCreatedDate($randomDate);
            $review->setComment('Comment about this hotel nr. '.$count);
            $review->setHotel($hotel);
        });
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
            HotelFixtures::class,
        ];
    }

}
