<?php

namespace App\Twig;

use App\Service\FileHandler;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FileExtension extends AbstractExtension
{
    public function __construct(private FileHandler $fileHandler) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('file', function ($path) {
                if (is_string($path) && str_starts_with($path, 'http')) {
                    return $path;
                }
                return $this->fileHandler->url($path);
            }),
        ];
    }
    
}
