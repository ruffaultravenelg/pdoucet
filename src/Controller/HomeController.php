<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Depeche;
use App\Entity\HeartPic;
use App\Entity\IndexLink;
use App\Form\DepecheType;
use App\Form\HeartPicType;
use App\Form\IndexLinkType;
use App\Service\AdminService;
use App\Service\FileHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    ///////////////////
    //// MAIN PAGE ////
    ///////////////////

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {

        // Get coup de coeurs
        $heartPic = $em->getRepository(HeartPic::class)->findBy([], ['id' => 'DESC'], 7);

        // Get positive & negative depeches
        $depeches = $em->getRepository(Depeche::class)->findBy(
            [],
            ['date' => 'DESC'],
            14
        );

        // Get links
        $links = $em->getRepository(IndexLink::class)->findAll();

        // Get last article
        $lastArticle = $em->getRepository(Article::class)->findOneBy([], ['date_modifed' => 'DESC']);
        if ($lastArticle) {
            $lastArticle = [
                'id' => $lastArticle->getId(),
                'title' => $lastArticle->getTitle(),
                'text' => $this->truncateHtml($lastArticle->getContent()),
            ];
        }

        // Render
        return $this->render('home/index.html.twig', [
            'heartPics' => $heartPic,
            'depeches' => $depeches,
            'links' => $links,
            'lastArticle' => $lastArticle,
        ]);

    }

    function truncateHtml($text, $maxLength = 200) {
        $printedLength = 0;
        $position = 0;
        $tags = [];
    
        $result = '';
    
        // Regex pour capturer les tags et le texte
        $regex = '/(<[^>]+>|[^<]+)/';
    
        preg_match_all($regex, $text, $tokens);
    
        foreach ($tokens[0] as $token) {
            if ($token[0] === '<') {
                // C'est une balise HTML
                if ($token[1] === '/') {
                    // Balise fermante
                    array_pop($tags);
                    $result .= $token;
                } else {
                    // Balise ouvrante ou auto-fermante
                    // Vérifie si c'est une balise auto-fermante
                    if (preg_match('/<(\w+)[^>]*\/>/', $token)) {
                        $result .= $token;
                    } else {
                        // Balise ouvrante normale
                        preg_match('/<(\w+)/', $token, $tagName);
                        $tags[] = $tagName[1];
                        $result .= $token;
                    }
                }
            } else {
                // C'est du texte
                $remaining = $maxLength - $printedLength;
    
                if (strlen($token) > $remaining) {
                    $result .= substr($token, 0, $remaining);
                    $printedLength += $remaining;
                    break;
                } else {
                    $result .= $token;
                    $printedLength += strlen($token);
                }
            }
    
            if ($printedLength >= $maxLength) {
                break;
            }
        }
    
        // Ferme les balises ouvertes restantes
        while (!empty($tags)) {
            $tag = array_pop($tags);
            $result .= "</$tag>";
        }
    
        return $result;
    }
    

    ///////////////////
    //// HEART PIC ////
    ///////////////////

    // Delete
    #[Route('/heartpic/{id}/delete', name: 'heartpic_delete')]
    public function heartpic_delete(EntityManagerInterface $em, HeartPic $heartPic, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($heartPic);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/heartpic/create', name: 'heartpic_create')]
    public function heartpic_create(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $heartPic = new HeartPic();
        $form = $this->createForm(HeartPicType::class, $heartPic, ['submit_label' => 'Ajouter', 'image_label' => 'Selectionner une image']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            if ($image) {
                $filename = $fileHandler->upload($image);
                $heartPic->setImage($filename);
            }

            $em->persist($heartPic);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_heartpic.html.twig', [
            'form' => $form
        ]);
        
    }

    // Edit
    #[Route('/heartpic/{id}/edit', name: 'heartpic_edit')]
    public function heartpic_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, HeartPic $heartPic, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(HeartPicType::class, $heartPic, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            if ($image) {
                $fileHandler->delete($heartPic->getImage()); // Remove old file if exist
                $filename = $fileHandler->upload($image);
                $heartPic->setImage($filename);
            }

            $em->flush();

            return $this->redirectToRoute('index');
        }

        // Render page
        return $this->render('home/edit_heartpic.html.twig', [
            'form' => $form,
            'heartpic' => $heartPic,
        ]);
        
    }

    ////////////////////
    //// INDEX LINK ////
    ////////////////////

    // Delete
    #[Route('/indexlink/{id}/delete', name: 'indexlink_delete')]
    public function indexlink_delete(EntityManagerInterface $em, IndexLink $indexLink, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($indexLink);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/indexlink/create', name: 'indexlink_create')]
    public function indexlink_create(EntityManagerInterface $em, AdminService $adminService, Request $request, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $indexLink = new IndexLink();
        $form = $this->createForm(IndexLinkType::class, $indexLink, ['submit_label' => 'Ajouter', 'image_label' => 'Selectionner une image']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            if ($image != null) {
                $filename = $fileHandler->upload($image);
                $indexLink->setImage($filename);
            }

            $em->persist($indexLink);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_indexlink.html.twig', [
            'form' => $form
        ]);
        
    }

    // Edit
    #[Route('/indexlink/{id}/edit', name: 'indexlink_edit')]
    public function indexlink_edit(EntityManagerInterface $em, AdminService $adminService, Request $request, IndexLink $indexLink, FileHandler $fileHandler): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(IndexLinkType::class, $indexLink, ['submit_label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle file upload
            $image = $form->get('image')->getData();
            if ($image) {
                $fileHandler->delete($indexLink->getImage()); // Remove old file if exist
                $filename = $fileHandler->upload($image);
                $indexLink->setImage($filename);
            }

            $em->flush();

            return $this->redirectToRoute('index');
        }

        // Render page
        return $this->render('home/edit_indexlink.html.twig', [
            'form' => $form,
            'indexlink' => $indexLink,
        ]);
        
    }

    /////////////////
    //// DEPECHE ////
    /////////////////

    // Delete
    #[Route('/depeche/{id}/delete', name: 'depeche_delete')]
    public function depeche_delete(EntityManagerInterface $em, Depeche $depeche, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($depeche);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    // Create
    #[Route('/depeche/create', name: 'depeche_create')]
    public function depeche_create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $depeche = new Depeche();
        $form = $this->createForm(DepecheType::class, $depeche);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $depeche->setDate(new \DateTimeImmutable()); // Set current date

            $em->persist($depeche);
            $em->flush();
            
            return $this->redirectToRoute('index');
        }
        
        // Render page
        return $this->render('home/create_depeche.html.twig', [
            'form' => $form
        ]);
        
    }

}
