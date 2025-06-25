<?php

namespace App\Service;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Yaml;

class SettingsLoader
{
    public function __construct(private EntityManagerInterface $em, private string $yamlPath = 'config/data/settings.yaml')
    {
        if (!file_exists($this->yamlPath)) {
            throw new \RuntimeException("Le fichier YAML n'existe pas : {$this->yamlPath}");
        }
    }

    /**
     * @return Setting[]
     */
    private function loadFromYaml(): array
    {
        if (!file_exists($this->yamlPath)) {
            throw new \RuntimeException("Fichier YAML introuvable : {$this->yamlPath}");
        }

        $data = Yaml::parseFile($this->yamlPath);
        $settings = [];

        // file like key: value
        foreach ($data as $key => $value) {
            if (!is_string($value)) {
                $value = (string)$value;
            }

            $setting = new Setting();
            $setting->setKey($key);
            $setting->setValue($value);
            $settings[] = $setting;
        }

        return $settings;
    }

    /**
     * Add new settings to the database from the YAML file.
     * @return void
     */
    public function updateDB(bool $eraseExistingSettings): void
    {
        // Get all settings from the YAML file
        $settings = $this->loadFromYaml();

        // If $eraseExistingSettings is true, delete all existing settings
        if ($eraseExistingSettings) {
            $this->em->createQuery('DELETE FROM App\Entity\Setting')->execute();
        }

        // Iterate through the settings and persist them
        foreach ($settings as $setting) {
            if (!$eraseExistingSettings) {
                // Check if setting with the same key already exists
                $existing = $this->em->getRepository(Setting::class)->findOneBy(['key' => $setting->getKey()]);
                if ($existing) {
                    continue; // Skip if already exists
                }
            }
            $this->em->persist($setting);
        }

        // Flush all changes to the database
        $this->em->flush();

    }

}
