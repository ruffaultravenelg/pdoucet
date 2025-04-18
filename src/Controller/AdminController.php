<?php

namespace App\Controller;

use App\Entity\Content;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
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

        if ($session->has('is_admin') && $session->get('is_admin')) {
            return $this->redirectToRoute('index');
        }

        $adminPath = $_ENV['ADMIN_PASS'];

        if ($request->isMethod('POST')) {
            $inputPassword = $request->request->get('password');

            if ($inputPassword === $adminPath) {
                $session->set('is_admin', true);
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('error', 'Mot de passe incorrect');
            }
        }

        return $this->render('admin/login.html.twig');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('index');
    }

    #[Route('/content', name: 'content')]
    public function content(AdminService $adminService, EntityManagerInterface $em): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Fetch content from the database
        $content = $em->getRepository(Content::class)->findAll();

        // Render
        return $this->render('admin/content.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/content/update', name: 'content_update', methods: ['POST'])]
    public function updateContent(Request $request, AdminService $adminService, EntityManagerInterface $em): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $contentKey = $request->request->get('key');
        $contentText = $request->request->get('content');

        // Fetch content from the database
        $content = $em->getRepository(Content::class)->find($contentKey);

        if ($content) {
            $content->setContent($contentText);
            $em->persist($content);
            $em->flush();
            return $this->redirectToRoute('content');
        }

        return new Response('Content not found', 404);
    }
 
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request, AdminService $adminService, SessionInterface $session): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
       
        // Render page
        return $this->render('admin/dashboard.html.twig');
    
    }

}
