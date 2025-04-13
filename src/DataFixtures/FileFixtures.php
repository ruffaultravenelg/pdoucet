<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class FileFixtures extends Fixture
{
    public function __construct(private string $fixtures_files_directory, private string $uploads_directory){}

    public function load(ObjectManager $manager): void
    {

        $filesystem = new Filesystem();
        $fixturesFiles = $this->fixtures_files_directory;
        $uploadsDir = $this->uploads_directory;

        if (!$filesystem->exists($uploadsDir)) {
            $filesystem->mkdir($uploadsDir);
        }

        $filesystem->mirror($fixturesFiles, $uploadsDir, null, ['override' => true]);

    }
}
