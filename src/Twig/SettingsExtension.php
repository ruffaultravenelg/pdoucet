<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Service\SettingsService;
use Twig\TwigFunction;

final class SettingsExtension extends AbstractExtension
{
    public function __construct(private SettingsService $settings) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setting', [$this, 'getSetting']),
        ];
    }

    public function getSetting(string $key): string
    {
        $setting = $this->settings->get($key);
        return $setting ? $setting : '';
    }

}
