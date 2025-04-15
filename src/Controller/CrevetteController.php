<?php

/*

Les routes crevettes sont des routes de tests
Elles servent a tester les technos du site

*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CrevetteController extends AbstractController
{

    #[Route('/crevette', name: 'crevette')]
    public function index(): Response
    {
        return $this->render('crevette/index.html.twig', [
        ]);
    }

}
