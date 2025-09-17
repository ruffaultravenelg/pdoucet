<?php

namespace App\Controller;

use App\Entity\UserRequest;
use App\Form\UserRequestType;
use App\Repository\ProductRepository;
use App\Repository\UserRequestRepository;
use App\Service\AdminService;
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

        $form = $this->createForm(UserRequestType::class, $userRequest, ['message_label' => $productId ? 'Informations complémentaires?' : null]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $userRequest->setDateCreated(new \DateTimeImmutable());
            $em->persist($userRequest);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('user_request/form.html.twig', [
            'form' => $form,
            'productName' => $userRequest->getProduct()?->getName() ?? null
        ]);
        
    }

    // Admin panel
    #[Route('/requests', name: 'requests')]
    public function requests(UserRequestRepository $userRequestRepository, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $requests = $userRequestRepository->findBy([], ['dateCreated' => 'DESC']);

        // Render page
        return $this->render('user_request/requests.html.twig', [
            'requests' => $requests
        ]);
        
    }

    // Admin panel
    #[Route('/request/{id}', name: 'request')]
    public function request(UserRequest $userRequest, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

            // Render page
        return $this->render('user_request/request.html.twig', [
            'request' => $userRequest
        ]);
        
    }

}
