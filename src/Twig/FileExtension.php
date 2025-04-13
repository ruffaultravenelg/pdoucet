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
            new TwigFunction('url', [$this->fileHandler, 'url']),
        ];
    }
}
