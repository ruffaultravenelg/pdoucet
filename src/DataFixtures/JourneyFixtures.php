<?php

namespace App\DataFixtures;

use App\Entity\Journey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JourneyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $journey1 = new Journey();
        $journey1->setDate(new \DateTimeImmutable('2023-10-01'));
        $journey1->setLocation('Paris, France');
        $journey1->setDescription('A wonderful journey through the streets of Paris.');
        $journey1->setLo(2.3522);
        $journey1->setLa(48.8566);
        $manager->persist($journey1);

        $journey2 = new Journey();
        $journey2->setDate(new \DateTimeImmutable('2023-10-02'));
        $journey2->setLocation('New York, USA');
        $journey2->setDescription('Exploring the vibrant city of New York.');
        $journey2->setLo(-74.0060);
        $journey2->setLa(40.7128);
        $manager->persist($journey2);

        $journey3 = new Journey();
        $journey3->setDate(new \DateTimeImmutable('2023-10-03'));
        $journey3->setLocation('Tokyo, Japan');
        $journey3->setDescription('A fascinating journey through the heart of Tokyo.');
        $journey3->setAddress('Shibuya, Tokyo, Japan');
        $manager->persist($journey3);

        $manager->flush();
    }
}
