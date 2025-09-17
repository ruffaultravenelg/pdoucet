<?php

namespace App\Controller;

use App\Entity\UserRequest;
use App\Form\UserRequestType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserRequestController extends AbstractController
{

    // Create
    #[Route('/message', name: 'request_create')]
    public function depeche_create(EntityManagerInterface $em, Request $request, ProductRepository $productRepository): Response
    {
        $userRequest = new UserRequest();
        
        $productId = $request->query->get('productId'); 
        if ($productId) {
            $product = $productRepository->find($productId);
            if ($product) {
                $userRequest->setProduct($product);
            }
        }

        $form = $this->createForm(UserRequestType::class, $userRequest);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($userRequest);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('user_request/form.html.twig', [
            'form' => $form
        ]);
        
    }

}
