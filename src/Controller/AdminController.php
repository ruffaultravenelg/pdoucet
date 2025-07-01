<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\HeaderLink;
use App\Entity\Page;
use App\Service\AdminService;
use App\Service\SettingsService;
use Doctrine\ORM\EntityManagerInterface;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
        $contents = $em->getRepository(Content::class)->findAll();

        // Create contents data
        $data = [];
        foreach ($contents as $content) {

            $formBuilder = $this->createFormBuilder()
                ->setAction($this->generateUrl('content_update', ['key' => $content->getKey()]))
                ->setMethod('POST');
            $this->addContentFieldToForm($formBuilder, $content->getType(), $content->getContent());

            array_push($data, [
                'elm' => $content,
                'form' => $formBuilder->getForm()->createView()
            ]);

        }

        // Render
        return $this->render('admin/content.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/content/{key}/update', name: 'content_update', methods: ['POST'])]
    public function updateContent(Request $request, AdminService $adminService, EntityManagerInterface $em, string $key): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Retrieve content
        $content = $em->getRepository(Content::class)->findOneBy(['key' => $key]);
        if (!$content) {
            return new Response('Content not found', 404);
        }

        // Create form
        $formBuilder = $this->createFormBuilder();
        $this->addContentFieldToForm($formBuilder, $content->getType());
        $form = $formBuilder->getForm();

        // Handle request
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return new Response('Invalid form submission', 400);
        }

        $content->setContent($form->getData()['content']);
        $em->persist($content);
        $em->flush();
        return $this->redirectToRoute('content');

    }

    private function addContentFieldToForm(FormBuilderInterface $builder, string $type, string $content = ''){

        if ($type === 'string'){
            $builder->add('content', TextType::class, [
                'attr' => ['class' => 'field'],
                'data' => $content,
            ]);

        } else if ($type === 'text') {
            $builder->add('content', TinymceType::class, [
                'data' => $content,
            ]);

        }

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

    #[Route('/pages', name: 'pages')]
    public function pages(AdminService $adminService, EntityManagerInterface $em): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Fetch pages from the database
        $pages = $em->getRepository(Page::class)->findAll();

        // Render
        return $this->render('admin/pages.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/settings', name: 'settings')]
    public function settings(AdminService $adminService, SettingsService $settingsService): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Fetch settings
        $settings = $settingsService->getAll();
        $settings = array_filter($settings, function ($se){ return $se->getKey() != "header"; });

        // Render
        return $this->render('admin/settings.html.twig', [
            'settings' => $settings,
        ]);
    }

    #[Route('/setting/{key}/update', name: 'settings_update', methods: ['POST'])]
    public function updateSetting(Request $request, AdminService $adminService, SettingsService $settingsService, string $key): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
        return new Response('Not authorized', 403);
        }


        // Handle form submission
        if ($request->isMethod('POST')) {
            // Payload is {value: 'value'}
            $data = json_decode($request->getContent(), true);
            if (!isset($data['value'])) {
                return new Response('Invalid data', 400);
            };
            $settingsService->set($key, $data['value']);
            return new Response('Setting updated successfully', 200);
        }

        return new Response('Invalid request method', 405);
    }

    #[Route('/header', name: 'header')]
    public function header(AdminService $adminService, EntityManagerInterface $em): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $headerLinks = [];

        return $this->render('admin/header.html.twig', [
            'links' => $headerLinks,
        ]);
    }

}
