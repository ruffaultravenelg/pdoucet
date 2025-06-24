<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\ContentLoader;

class ContentFixtures extends Fixture
{
    public function __construct() {}

    public function load(ObjectManager $om): void
    {
        $loader = new ContentLoader($om);
        $loader->updateDB(false);
    }

}
