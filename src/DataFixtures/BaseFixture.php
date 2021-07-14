<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    const BATCH_SIZE=5000;
    /** @var ObjectManager */
    private $manager;


    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, bool $isAddReference, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            if ($isAddReference) {
                $this->addReference($className . '_' . $i, $entity);
            }
            if (($i % self::BATCH_SIZE) === 0) {
                $this->manager->flush();
                $this->manager->clear();
            }
        }
    }
}
