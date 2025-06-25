<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\SettingsLoader;

class SettingFixtures extends Fixture
{
    public function __construct() {}

    public function load(ObjectManager $om): void
    {
        $loader = new SettingsLoader($om);
        $loader->updateDB(false);
    }

}
