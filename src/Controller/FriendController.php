<?php

namespace App\Controller;

use App\Entity\Friend;
use App\Form\FriendType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FriendController extends AbstractController
{
    #[Route('/amis', name: 'friends')]
    public function amis(EntityManagerInterface $em): Response
    {
        $amis = $em->getRepository(Friend::class)->findAll();

        return $this->render('friend/index.html.twig', [
            'amis' => $amis,
        ]);

    }

    #[Route('/ami/{id}/delete', name: 'friend_delete')]
    public function delete(EntityManagerInterface $em, Friend $friend, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($friend);
        $em->flush();

        return $this->redirectToRoute('friends');
    }
    

    #[Route('/ami/create', name: 'friend_create')]
    public function create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $friend = new Friend();
        $form = $this->createForm(FriendType::class, $friend, ['submit_label' => 'Ajouter']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($friend);
            $em->flush();
            
            return $this->redirectToRoute('friends');

        }
        
        // Render page
        return $this->render('friend/create.html.twig', [
            'form' => $form
        ]);
        
    }

    #[Route('/ami/{id}/edit', name: 'friend_edit')]
    public function edit(EntityManagerInterface $em, AdminService $adminService, Request $request, Friend $friend): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(FriendType::class, $friend, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('friends');
        }

        // Render page
        return $this->render('friend/edit.html.twig', [
            'form' => $form,
            'friend' => $friend,
        ]);
        
    }

}
