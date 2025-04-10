<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class AdminService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    private function getSession()
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request ? $request->getSession() : null;
    }

    public function isAdmin(): bool
    {
        $session = $this->getSession();
        return $session ? $session->get('is_admin', false) : false;
    }

    public function login(): void
    {
        $session = $this->getSession();
        if ($session) {
            $session->set('is_admin', true);
        }
    }

    public function logout(): void
    {
        $session = $this->getSession();
        if ($session) {
            $session->remove('is_admin');
        }
    }
}
