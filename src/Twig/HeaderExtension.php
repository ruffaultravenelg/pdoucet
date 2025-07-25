<?php
namespace App\Twig;

use App\Repository\PageRepository;
use App\Service\SettingsService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class HeaderExtension extends AbstractExtension implements GlobalsInterface
{

    public function __construct(private SettingsService $settingsService, private PageRepository $pageRepository) {}

    public function getGlobals(): array
    {
        // Get header json from settings
        $rawHeaderJson = $this->settingsService->get('header'); // [ { "title": "", "path": "#" }, { "pageId": "" } ]
        $headerJson = json_decode($rawHeaderJson, true);

        $headerLinks = [];
        foreach ($headerJson as $link) {

            // A page
            if (isset($link['pageId'])){
                $page = $this->pageRepository->find($link['pageId']);
                if (!$page) continue; 
                $headerLinks[] = [
                    'title' => $page->getName(),
                    'path' => "/p/" . $page->getSlug(),
                ];
                continue;
            }

            // A custom path
            if (isset($link['title']) && isset($link['path'])) {
                $headerLinks[] = [
                    'title' => $link['title'],
                    'path' => $link['path'],
                ];
                continue;
            }

        }

        return [
            'header_links' => $headerLinks,
        ];
    }
}