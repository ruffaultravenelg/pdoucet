<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles')]
    public function articles(EntityManagerInterface $em, AdminService $adminService): Response
    {

        // Get articles
        $articles = $em->getRepository(Article::class)->findBy(
            ['visible' => true],
            ['date_modifed' => 'DESC']
        );

        // If admin, get hidden articles
        $hiddenArticles = [];
        if ($adminService->isAdmin()) {
            $hiddenArticles = $em->getRepository(Article::class)->findBy(
                ['visible' => false],
                ['date_modifed' => 'DESC']
            );
        }

        $all_tags = [];
        foreach ($articles as $article) {
            $tags = explode(',', $article->getTags());
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (!in_array($tag, $all_tags)) {
                    $all_tags[] = $tag;
                }
            }
        }
        foreach ($hiddenArticles as $article) {
            $tags = explode(',', $article->getTags());
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (!in_array($tag, $all_tags)) {
                    $all_tags[] = $tag;
                }
            }
        }

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
            'hiddenArticles' => $hiddenArticles,
            'all_tags' => $all_tags,
        ]);

    }
    
    #[Route('/article/{id}/view', name: 'article')]
    public function article(Article $article, AdminService $adminService, EntityManagerInterface $em): Response
    {

        // Check if article is visible
        if (!$article->isVisible() && !$adminService->isAdmin()) {
            return $this->redirectToRoute('articles');
        }

        if (!$adminService->isAdmin()){
            $em->createQuery('UPDATE App\Entity\Article a SET a.visitCount = a.visitCount + 1 WHERE a.id = :id')
                ->setParameter('id', $article->getId())
                ->execute();
        }

        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/{id}/delete', name: 'article_delete')]
    public function delete(EntityManagerInterface $em, Article $article, AdminService $adminService): Response
    {
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('articles');
    }
    

    #[Route('/article/create', name: 'article_create')]
    public function create(EntityManagerInterface $em, AdminService $adminService, Request $request): Response
    {
        
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article, ['submit_label' => 'Ajouter']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Add content
            $article->setContent('');

            // Add dates
            $article->setDateCreated(new \DateTimeImmutable());
            $article->setDateModifed(new \DateTimeImmutable());

            // If tag is empty
            if (empty($article->getTags())) {
                $article->setTags('');
            }

            // Update db
            $em->persist($article);
            $em->flush();
            
            return $this->redirectToRoute('article', ['id' => $article->getId()]);

        }
        
        // Render page
        return $this->render('article/create.html.twig', [
            'form' => $form
        ]);

    }
    

    #[Route('/article/{id}/edit', name: 'article_edit')]
    public function edit(EntityManagerInterface $em, AdminService $adminService, Article $article, Request $request): Response
    {
        
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(ArticleType::class, $article, ['submit_label' => 'Mettre à jour']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Add dates
            $article->setDateModifed(new \DateTimeImmutable());

            // If tag is empty
            if (empty($article->getTags())) {
                $article->setTags('');
            }

            // Update db
            $em->persist($article);
            $em->flush();
            
            return $this->redirectToRoute('article', ['id' => $article->getId()]);

        }
        
        // Render page
        return $this->render('article/edit.html.twig', [
            'form' => $form,
            'articleId' => $article->getId()
        ]);

    }
    

    #[Route('/article/{id}/write', name: 'article_write')]
    public function write(EntityManagerInterface $em, AdminService $adminService, Article $article, Request $request): Response
    {
        
        // Check permission
        if (!$adminService->isAdmin()) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createFormBuilder()
            ->add('content', TextareaType::class, [
                'data' => $article->getContent(),
                'attr' => [
                    'class' => 'tinymce',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour',
            ])
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Update content
            $article->setContent($form->get('content')->getData());

            // Update date
            $article->setDateModifed(new \DateTimeImmutable());

            // Update db
            $em->persist($article);
            $em->flush();
            
            return $this->redirectToRoute('article', ['id' => $article->getId()]);

        }
        
        // Render page
        return $this->render('article/write.html.twig', [
            'form' => $form,
            'articleId' => $article->getId()
        ]);

    }

}
