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
        $link1->setImage('link_amis.png');
        $manager->persist($link1);

        $link2 = new IndexLink();
        $link2->setName('Crevette');
        $link2->setUrl('/crevette');
        $link2->setImage('crevette.gif');
        $manager->persist($link2);

        $manager->flush();
    }
}
