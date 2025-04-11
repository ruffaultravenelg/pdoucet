<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Content('index.quote', '"Notre temps a besoin d’êtres qui soient comme des arbres, emplis d’une paix qui s’enracine dans la terre et le ciel."'));
        $manager->persist(new Content('index.quote.author', 'Olivier Clément'));
        $manager->persist(new Content('fullname', 'Pascal Doucet'));
        $manager->flush();
    }
}
