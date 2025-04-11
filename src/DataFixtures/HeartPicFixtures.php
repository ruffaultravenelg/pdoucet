<?php

namespace App\DataFixtures;

use App\Entity\HeartPic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeartPicFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $heartPic1 = new HeartPic();
        $heartPic1->setTitle('Titre de l\'article');
        $heartPic1->setSubtitle('Film');
        $heartPic1->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $heartPic1->setImage('https://picsum.photos/200/300');
        $heartPic1->setLink('https://www.google.com');
        $manager->persist($heartPic1);

        $heartPic2 = new HeartPic();
        $heartPic2->setTitle('Another Article Title');
        $heartPic2->setSubtitle('Book');
        $heartPic2->setText('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.');
        $heartPic2->setImage('https://picsum.photos/200/301');
        $heartPic2->setLink('https://www.example.com');
        $manager->persist($heartPic2);

        $heartPic3 = new HeartPic();
        $heartPic3->setTitle('Yet Another Article Title');
        $heartPic3->setSubtitle('Music');
        $heartPic3->setText('At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque.');
        $heartPic3->setImage('https://picsum.photos/200/302');
        $heartPic3->setLink('https://www.anotherexample.com');
        $manager->persist($heartPic3);

        $manager->flush();
    }
}
