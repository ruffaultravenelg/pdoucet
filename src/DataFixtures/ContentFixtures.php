<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\ContentLoader;

class ContentFixtures extends Fixture
{
    public function __construct(private ContentLoader $loader) {}

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loader->loadFromYaml() as $content) {
            $manager->persist($content);
        }

        $manager->flush();
    }

}
