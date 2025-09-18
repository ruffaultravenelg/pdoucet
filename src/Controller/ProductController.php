<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\AdminService;
use App\Service\FileHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/services', name: 'products')]
    public function index(EntityManagerInterface $em): Response
    {

        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);

    }

    // Create
    #[Route('/product/create', name: 'product_create')]
    public function product_create(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, ['submit_label' => 'Ajouter', 'image_label' => 'Selectionner une image', 'force_image_upload' => true]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            $filename = $fileHandler->upload($image);
            $product->setImage($filename);

            // Persist in db
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products');
        }
        
        // Render page
        return $this->render('product/form.html.twig', [
            'form' => $form,
            'title' => 'Ajouter un service',
        ]);
        
    }

    // Edit
    #[Route('/product/{id}/edit', name: 'product_edit')]
    public function product_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler, Product $product): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(ProductType::class, $product, ['submit_label' => 'Modifier', 'image_label' => 'Changer l\'image (optionnel)', 'force_image_upload' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            if ($image != null) {
                $fileHandler->delete($product->getImage());
                $product->setImage($fileHandler->upload($image));
            }

            // Persist in db
            $em->flush();

            return $this->redirectToRoute('products');
        }
        
        // Render page
        return $this->render('product/form.html.twig', [
            'form' => $form,
            'title' => 'Modifier un service',
        ]);
        
    }

    // Delete
    #[Route('/product/{id}/delete', name: 'product_delete')]
    public function product_delete(EntityManagerInterface $em, AdminService $adminService, FileHandler $fileHandler, Product $product): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        // Delete product image
        $fileHandler->delete($product->getImage());

        // Remove product from db
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('products');
    }

}
