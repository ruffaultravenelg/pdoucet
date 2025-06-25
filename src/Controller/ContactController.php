<?php

namespace App\Controller;

use App\Service\SettingsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(SettingsService $settings): Response
    {

        // Load settings
        $email = $settings->get('email');
        $phone = $settings->get('phone');
        $address = $settings->get('address');

        // Render page
        return $this->render('contact/index.html.twig', [
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
        ]);

    }
}
