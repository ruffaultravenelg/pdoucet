<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Form\ArticleSearchType;
use App\Form\ArticleType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles')]
    public function articles(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request, AdminService $adminService): Response
    {

        $form = $this->createForm(ArticleSearchType::class, null, ['csrf_protection' => false, 'allow_extra_fields' => true, 'is_admin' => $adminService->isAdmin()]);
        $form->handleRequest($request);

        // Get articles
        $query = $em->getRepository(Article::class)
            ->createQueryBuilder('a');

        $visibility = true;
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('q')->getData();
            if ($search) {
                $query->where('a.title LIKE :search OR a.tags LIKE :search')
                ->setParameter('search', '%'.$search.'%');
            }
            if ($adminService->isAdmin() && $form->get('h')->getData()) {
                $visibility = false;
            }
        }
        
        $query
            ->andWhere('a.visible = :visible')
            ->setParameter('visible', $visibility)
            ->orderBy('a.date_modifed', 'DESC');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('article/articles.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
            'showHiddenArticles' => !$visibility,
        ]);

    }
    
    #[Route('/article/{id}/view', name: 'article')]
    public function article(Article $article, AdminService $adminService, EntityManagerInterface $em, Request $request): Response
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

        $likeCount = $em->createQuery('SELECT COUNT(l.id) FROM App\Entity\ArticleLike l WHERE l.Article = :article')
            ->setParameter('article', $article)
            ->getSingleScalarResult();

        $liked = $this->doUserLikedArticle($article, $request->getClientIp(), $em);

        return $this->render('article/article.html.twig', [
            'article' => $article,
            'likeCount' => $likeCount,
            'liked' => $liked
        ]);
    }

    #[Route('/article/{id}/like', name: 'article_like')]
    public function like_article(Request $request, EntityManagerInterface $em): Response
    {
        $ipAddress = $request->getClientIp();

        // Find article
        $article = $em->getRepository(Article::class)->find($request->attributes->get('id'));

        // Check if the user has already liked the article
        $existingLike = $this->doUserLikedArticle($article, $ipAddress, $em);

        if ($existingLike) {
            // User has already liked the article, do nothing
            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        // Create a new like
        $like = new ArticleLike();
        $like->setArticle($article);
        $like->setIpAddress($ipAddress);
        $like->setDate(new \DateTimeImmutable());

        $em->persist($like);
        $em->flush();

        return $this->redirectToRoute('article', ['id' => $article->getId()]);
    }

    private function doUserLikedArticle(Article $article, string $ipAddress, EntityManagerInterface $em): bool
    {
        $existingLike = $em->getRepository(ArticleLike::class)->findOneBy([
            'Article' => $article,
            'ip_address' => $ipAddress,
        ]);
        return $existingLike !== null;
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
