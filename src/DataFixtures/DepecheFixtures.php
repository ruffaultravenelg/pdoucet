<?php

namespace App\DataFixtures;

use App\Entity\Depeche;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepecheFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $depeche1 = new Depeche();
        $depeche1->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $depeche1->setDate(new \DateTimeImmutable('2023-10-01'));
        $manager->persist($depeche1);

        $depeche2 = new Depeche();
        $depeche2->setText('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $depeche2->setDate(new \DateTimeImmutable('2023-10-02'));
        $manager->persist($depeche2);

        $depeche3 = new Depeche();
        $depeche3->setText('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $depeche3->setDate(new \DateTimeImmutable('2023-10-03'));
        $manager->persist($depeche3);
        
        $depeche4 = new Depeche();
        $depeche4->setText('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
        $depeche4->setDate(new \DateTimeImmutable('2023-10-04'));
        $manager->persist($depeche4);
        
        $depeche5 = new Depeche();
        $depeche5->setText('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $depeche5->setDate(new \DateTimeImmutable('2023-10-05'));
        $manager->persist($depeche5);

        $manager->flush();
    }
}
