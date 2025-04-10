<?php

namespace App\DataFixtures;

use App\Entity\Friend;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FriendFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $friend1 = new Friend();
        $friend1->setFullname('John Doe');
        $friend1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $friend1->setAvatarUrl('https://picsum.photos/200');
        $friend1->setWebsiteUrl('https://example.com');
        $friend1->setFacebookUrl('https://facebook.com/johndoe');
        $manager->persist($friend1);

        $friend2 = new Friend();
        $friend2->setFullname('Jane Smith');
        $manager->persist($friend2);

        $friend3 = new Friend();
        $friend3->setFullname('Alice Johnson');
        $friend3->setDescription('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $friend3->setAvatarUrl('https://picsum.photos/200');
        $manager->persist($friend3);

        $friend4 = new Friend();
        $friend4->setFullname('Bob Brown');
        $friend4->setWebsiteUrl('https://bobbrown.com');
        $manager->persist($friend4);

        $manager->flush();
    }
}
