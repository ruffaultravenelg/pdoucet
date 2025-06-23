<?php

namespace App\Controller;

use App\Entity\Content;
use App\Service\AdminService;
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

}
