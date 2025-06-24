<?php

namespace App\Service;

use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Yaml;

class ContentLoader
{
    public function __construct(private EntityManagerInterface $em, private string $yamlPath = 'config/data/content.yaml')
    {
        if (!file_exists($this->yamlPath)) {
            throw new \RuntimeException("Le fichier YAML n'existe pas : {$this->yamlPath}");
        }
    }

    /**
     * @return Content[]
     */
    private function loadFromYaml(): array
    {
        if (!file_exists($this->yamlPath)) {
            throw new \RuntimeException("Fichier YAML introuvable : {$this->yamlPath}");
        }

        $data = Yaml::parseFile($this->yamlPath);
        $contents = [];

        foreach ($data as $key => $item) {
            if (!isset($item['value'])) {
                continue;
            }

            $type = $item['type'] ?? 'string';
            $contents[] = new Content($key, $item['value'], $type);
        }

        return $contents;
    }

    /**
     * Add new contents to the database from the YAML file.
     * @return void
     */
    public function updateDB(bool $eraseExistingContent): void
    {
        // Get all contents from the YAML file
        $contents = $this->loadFromYaml();

        // If $eraseExistingContent is true, delete all existing contents
        if ($eraseExistingContent) {
            $this->em->createQuery('DELETE FROM App\Entity\Content')->execute();
        }

        // Iterate through the contents and persist them
        foreach ($contents as $content) {
            if (!$eraseExistingContent) {
                // Check if content with the same key already exists
                $existing = $this->em->getRepository(Content::class)->findOneBy(['key' => $content->getKey()]);
                if ($existing) {
                    continue; // Skip if already exists
                }
            }
            $this->em->persist($content);
        }

        // Flush all changes to the database
        $this->em->flush();

    }

}
