<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Service\AdminService;

class AdminExtension extends AbstractExtension
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function test(){
        return true;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_admin', [$this->adminService, 'isAdmin']),
        ];
    }
}

