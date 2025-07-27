<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatisticsController extends AbstractController
{

    #[Route('/statistics', name: 'statistics')]
    public function index(EntityManagerInterface $em, AdminService $adminService): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Get articles visit count
        $articleTable = $this->getArticleTable($em);

        return $this->render('statistics/index.html.twig', [
            'articleTable' => $articleTable,
        ]);

    }

    private function getArticleTable(EntityManagerInterface $em): array
    {
        $allArticles = $em->getRepository(Article::class)->findAll();
        $articleTable = [];
        foreach ($allArticles as $article) {
            $row = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'visitCount' => $article->getVisitCount(),
            ];
            array_push($articleTable, $row);
        }
        usort($articleTable, function ($a, $b) {
            return $b['visitCount'] <=> $a['visitCount'];
        });
        return $articleTable;
    }
    
}
