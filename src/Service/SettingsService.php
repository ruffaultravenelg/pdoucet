<?php

namespace App\Service;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;

class SettingsService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function get(string $key): ?string
    {
        $setting = $this->em->getRepository(Setting::class)->findOneBy(['key' => $key]);
        return $setting ? $setting->getValue() : null;
    }

    public function set(string $key, string $value): void
    {
        $setting = $this->em->getRepository(Setting::class)->findOneBy(['key' => $key]);

        if (!$setting) {
            $setting = new Setting();
            $setting->setKey($key);
        }

        $setting->setValue($value);
        $this->em->persist($setting);
        $this->em->flush();
    }
  
}
