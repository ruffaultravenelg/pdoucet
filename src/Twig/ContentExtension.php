<?php

namespace App\Twig;

use App\Repository\ContentRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ContentExtension extends AbstractExtension
{
    private ContentRepository $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('content', [$this, 'getContent']),
        ];
    }

    public function getContent(string $key): string
    {
        $content = $this->contentRepository->find($key);

        return $content ? $content->getContent() : '';
    }
}
