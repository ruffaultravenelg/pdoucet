<?php

namespace App\Controller;

use App\Entity\Depeche;
use App\Entity\HeartPic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {

        // Get coup de coeurs
        $heartPic = $em->getRepository(HeartPic::class)->findAll();

        // Get positive & negative depeches
        $positiveDepeches = $em->getRepository(Depeche::class)->findBy(
            ['is_positive' => true],
            ['date' => 'DESC']
        );
        $negativeDepeches = $em->getRepository(Depeche::class)->findBy(
            ['is_positive' => false],
            ['date' => 'DESC']
        );

        // Render
        return $this->render('home/index.html.twig', [
            'heartPics' => $heartPic,
            'positiveDepeches' => $positiveDepeches,
            'negativeDepeches' => $negativeDepeches,
        ]);


    }

}
