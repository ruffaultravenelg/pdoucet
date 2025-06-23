<?php

namespace App\Service;

use App\Entity\Content;
use Symfony\Component\Yaml\Yaml;

class ContentLoader
{
    public function __construct(private string $yamlPath = 'config/data/content.yaml')
    {
    }

    /**
     * @return Content[]
     */
    public function loadFromYaml(): array
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
}
