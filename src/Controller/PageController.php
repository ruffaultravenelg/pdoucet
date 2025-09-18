<?php

namespace App\Controller;

use App\Entity\IndexLink;
use App\Entity\Page;
use App\Form\PageType;
use App\Service\AdminService;
use App\Service\FileHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    
    #[Route('/p/{slug}', name: 'page')]
    public function index(string $slug, EntityManagerInterface $em): Response
    {

        $page = $em->getRepository(Page::class)->findOneBy(['slug' => $slug]);

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }

    // Delete
    #[Route('/page/{id}/delete', name: 'page_delete')]
    public function page_delete(EntityManagerInterface $em, Page $page, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $indexLinks = $em->getRepository(IndexLink::class)->findBy(['page' => $page]);
        foreach ($indexLinks as $indexLink) {
            $em->remove($indexLink);
        }

        $em->remove($page);
    
        $em->flush();

        return $this->redirectToRoute('pages');
    }

    // Create
    #[Route('/page/create', name: 'page_create')]
    public function page_create(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $page = new Page();
        $form = $this->createForm(PageType::class, $page, ['submit_label' => 'Ajouter', 'image_label' => 'Selectionner une image (optionnel)']);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('headerImage')->getData();
            if ($image != null) {
                $filename = $fileHandler->upload($image);
                $page->setHeaderImage($filename);
            }

            // Set dates
            $page->setCreationDate(new \DateTimeImmutable());
            $page->setLastModificationDate(new \DateTimeImmutable());

            // Persist in db
            $em->persist($page);
            $em->flush();
            
            return $this->redirectToRoute('page', ['slug' => $page->getSlug()]);
        }
        
        // Render page
        return $this->render('page/create.html.twig', [
            'form' => $form
        ]);
        
    }

    // Edit
    #[Route('/page/{id}/edit', name: 'page_edit')]
    public function page_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, Page $page, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $canDeleteImage = $page->getHeaderImage() ? true : false;
        $form = $this->createForm(PageType::class, $page, ['submit_label' => 'Modifier', 'image_label' => 'Selectionner une nouvelle image', 'delete_image' => $canDeleteImage]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload and deletion
            $image = $form->get('headerImage')->getData();
            $remove = $canDeleteImage ? $form->get('deleteImage')->getData() : false;

            if ($remove) {
                $page->setHeaderImage(null);
            } elseif ($image !== null) {
                $fileHandler->delete($page->getHeaderImage());
                $page->setHeaderImage($fileHandler->upload($image));
            }

            // Update dates
            $page->setLastModificationDate(new \DateTimeImmutable());

            // Persist in db
            $em->flush();

            return $this->redirectToRoute('page', ['slug' => $page->getSlug()]);
        }

        // Render page
        return $this->render('page/edit.html.twig', [
            'form' => $form,
        ]);
        
    }

}
