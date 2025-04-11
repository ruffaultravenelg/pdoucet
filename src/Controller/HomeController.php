<?php

namespace App\Controller;

use App\Entity\Depeche;
use App\Entity\HeartPic;
use App\Entity\IndexLink;
use App\Form\DepecheType;
use App\Form\HeartPicType;
use App\Form\IndexLinkType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    ///////////////////
    //// MAIN PAGE ////
    ///////////////////

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {

        // Get coup de coeurs
        $heartPic = $em->getRepository(HeartPic::class)->findBy([], ['id' => 'DESC'], 7);

        // Get positive & negative depeches
        $positiveDepeches = $em->getRepository(Depeche::class)->findBy(
            ['is_positive' => true],
            ['date' => 'DESC'],
            7
        );

        $negativeDepeches = $em->getRepository(Depeche::class)->findBy(
            ['is_positive' => false],
            ['date' => 'DESC'],
            7
        );

        // Get links
        $links = $em->getRepository(IndexLink::class)->findAll();

        // Render
        return $this->render('home/index.html.twig', [
            'heartPics' => $heartPic,
            'positiveDepeches' => $positiveDepeches,
            'negativeDepeches' => $negativeDepeches,
            'links' => $links,
        ]);

    }

    ///////////////////
    //// HEART PIC ////
    ///////////////////

    // Delete
    #[Route('/heartpic/{id}/delete', name: 'heartpic_delete')]
    public function heartpic_delete(EntityManagerInterface $em, HeartPic $heartPic, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($heartPic);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/heartpic/create', name: 'heartpic_create')]
    public function heartpic_create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $heartPic = new HeartPic();
        $form = $this->createForm(HeartPicType::class, $heartPic, ['submit_label' => 'Ajouter']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($heartPic);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_heartpic.html.twig', [
            'form' => $form
        ]);
        
    }

    // Edit
    #[Route('/heartpic/{id}/edit', name: 'heartpic_edit')]
    public function heartpic_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, HeartPic $heartPic): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(HeartPicType::class, $heartPic, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('index');
        }

        // Render page
        return $this->render('home/edit_heartpic.html.twig', [
            'form' => $form,
            'heartpic' => $heartPic,
        ]);
        
    }

    ////////////////////
    //// INDEX LINK ////
    ////////////////////

    // Delete
    #[Route('/indexlink/{id}/delete', name: 'indexlink_delete')]
    public function indexlink_delete(EntityManagerInterface $em, IndexLink $indexLink, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($indexLink);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/indexlink/create', name: 'indexlink_create')]
    public function indexlink_create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $indexLink = new IndexLink();
        $form = $this->createForm(IndexLinkType::class, $indexLink, ['submit_label' => 'Ajouter']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($indexLink);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_indexlink.html.twig', [
            'form' => $form
        ]);
        
    }

    // Edit
    #[Route('/indexlink/{id}/edit', name: 'indexlink_edit')]
    public function indexlink_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, IndexLink $indexLink): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(IndexLinkType::class, $indexLink, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('index');
        }

        // Render page
        return $this->render('home/edit_indexlink.html.twig', [
            'form' => $form,
            'indexlink' => $indexLink,
        ]);
        
    }

    /////////////////
    //// DEPECHE ////
    /////////////////

    // Delete
    #[Route('/depeche/{id}/delete', name: 'depeche_delete')]
    public function depeche_delete(EntityManagerInterface $em, Depeche $depeche, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($depeche);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/depeche/create', name: 'depeche_create')]
    public function depeche_create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $depeche = new Depeche();
        $form = $this->createForm(DepecheType::class, $depeche);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $depeche->setDate(new \DateTimeImmutable()); // Set current date

            $em->persist($depeche);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_depeche.html.twig', [
            'form' => $form
        ]);
        
    }

}
