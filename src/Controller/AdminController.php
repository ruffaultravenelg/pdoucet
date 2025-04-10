<?php

namespace App\Controller;

use App\Service\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
 
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $adminPath = $_ENV['ADMIN_PATH'];

        if ($request->isMethod('POST')) {
            $inputPassword = $request->request->get('password');

            if ($inputPassword === $adminPath) {
                $session->set('is_admin', true);
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('error', 'Mot de passe incorrect');
            }
        }

        if ($session->has('is_admin') && $session->get('is_admin')) {
            return $this->redirectToRoute('index');
        }

        return $this->render('admin/login.html.twig');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('index');
    }
    
}
