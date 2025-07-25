<?php

namespace App\Controller;

use App\Entity\Journey;
use App\Form\JourneyType;
use App\Repository\JourneyRepository;
use App\Service\AdminService;
use App\Service\FileHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JourneyController extends AbstractController
{

    #[Route('/journey', name: 'journey')]
    public function index(JourneyRepository $journeyRepository): Response
    {
        $journeys = $journeyRepository->findBy([], ['date' => 'DESC']);

        return $this->render('journey/index.html.twig', [
            'journeys' => $journeys,
        ]);
    }

    #[Route('/journey/new', name: 'journey_new')]
    public function create(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $journey = new Journey();
        $form = $this->createForm(JourneyType::class, $journey, ['submit_label' => 'Ajouter']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($journey);
            $em->flush();
            
            return $this->redirectToRoute('journey');

        }
        
        // Render page
        return $this->render('journey/new.html.twig', [
            'form' => $form
        ]);
        
    }

    #[Route('/journey/{id}/edit', name: 'journey_edit')]
    public function edit(EntityManagerInterface $em, AdminService $adminService, Request $request, Journey $journey): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(JourneyType::class, $journey, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('journey');
        }

        // Render page
        return $this->render('journey/edit.html.twig', [
            'form' => $form,
        ]);
        
    }

    #[Route('/journey/{id}/delete', name: 'journey_delete')]
    public function delete(EntityManagerInterface $em, Journey $journey, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($journey);
        $em->flush();

        return $this->redirectToRoute('journey');
    }

}
