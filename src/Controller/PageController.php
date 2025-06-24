<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}
