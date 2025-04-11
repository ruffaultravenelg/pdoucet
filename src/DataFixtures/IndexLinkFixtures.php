<?php

namespace App\DataFixtures;

use App\Entity\IndexLink;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IndexLinkFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $link1 = new IndexLink();
        $link1->setName('Amis');
        $link1->setUrl('/amis');
        $link1->setImage('https://picsum.photos/200');
        $manager->persist($link1);

        $link2 = new IndexLink();
        $link2->setName('Liens');
        $link2->setUrl('/liens');
        $link2->setImage('https://picsum.photos/200');
        $manager->persist($link2);

        $link3 = new IndexLink();
        $link3->setName('Contact');
        $link3->setUrl('/contact');
        $link3->setImage('https://picsum.photos/200');
        $manager->persist($link3);

        $manager->flush();
    }
}
