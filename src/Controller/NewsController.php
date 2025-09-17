<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $em->getRepository(News::class)->createQueryBuilder('n');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('news/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/news/create', name: 'news_create')]
    public function create(AdminService $adminService, Request $request, EntityManagerInterface $em): Response
    {

        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $news = new News();
        $form = $this->createForm(NewsType::class, $news, ['confirm_label' => 'Ajouter']);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Set date
            $news->setDate(new \DateTimeImmutable());

            // Persist in db
            $em->persist($news);
            $em->flush();
            
            return $this->redirectToRoute('news');
        }
        
        // Render form
        return $this->render('news/form.html.twig', [
            'form' => $form,
            'title' => 'Ajouter une nouvelle',
        ]);

    }

    #[Route('/news/{id}/edit', name: 'news_edit')]
    public function edit(AdminService $adminService, Request $request, EntityManagerInterface $em, News $news): Response
    {

        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(NewsType::class, $news, ['confirm_label' => 'Mettre à jour']);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Persist in db
            $em->persist($news);
            $em->flush();
            
            return $this->redirectToRoute('news');
        }
        
        // Render form
        return $this->render('news/form.html.twig', [
            'form' => $form,
            'title' => 'Modifier une nouvelle',
        ]);

    }

    #[Route('/news/{id}/delete', name: 'news_delete')]
    public function news_delete(EntityManagerInterface $em, News $news, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($news);
        $em->flush();

        return $this->redirectToRoute('news');
    }

}
