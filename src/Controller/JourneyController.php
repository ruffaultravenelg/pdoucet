<?php

namespace App\Controller;

use App\Repository\JourneyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}
