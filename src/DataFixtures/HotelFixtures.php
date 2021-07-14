<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HotelFixtures extends BaseFixture implements DependentFixtureInterface
{
    const RECORDS_NR = 10;
    const TO_ADD_REFERENCE = true;

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Hotel::class, self::RECORDS_NR, self::TO_ADD_REFERENCE, function(Hotel $hotel, $count) {
            $hotel->setName('HotelNr'.$count);
        });
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }

}
