<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article1 = new Article();
        $article1->setTitle('Understanding Symfony 6');
        $article1->setSubtitle('An introduction to the Symfony framework.');
        $article1->setDateCreated(new \DateTimeImmutable('2023-10-01'));
        $article1->setDateModifed(new \DateTimeImmutable('2023-10-01'));
        $article1->setTags("Symfony;PHP;Web Development");
        $article1->setContent('<p>Symfony 6 is a <strong>powerful PHP framework</strong> for web applications.</p>');
        $article1->setAuthor('John Doe');
        $article1->setVisible(true);
        $manager->persist($article1);

        $article2 = new Article();
        $article2->setTitle('Getting Started with Doctrine');
        $article2->setSubtitle('A guide to using Doctrine ORM with Symfony.');
        $article2->setDateCreated(new \DateTimeImmutable('2023-10-02'));
        $article2->setDateModifed(new \DateTimeImmutable('2023-10-02'));
        $article2->setTags("Doctrine;ORM;Database");
        $article2->setContent('<p>Doctrine is a powerful ORM for PHP that integrates well with Symfony.</p>');
        $article2->setAuthor('Jane Smith');
        $article2->setVisible(true);
        $manager->persist($article2);

        $article3 = new Article();
        $article3->setTitle('Building REST APIs with Symfony');
        $article3->setSubtitle('Learn how to create RESTful APIs using Symfony.');
        $article3->setDateCreated(new \DateTimeImmutable('2023-10-03'));
        $article3->setDateModifed(new \DateTimeImmutable('2023-10-03'));
        $article3->setTags("API;REST;Symfony");
        $article3->setContent('<p>Creating REST APIs with Symfony is straightforward and efficient.</p>');
        $article3->setAuthor('Alice Johnson');
        $article3->setVisible(true);
        $manager->persist($article3);

        $article4 = new Article();
        $article4->setTitle('Symfony Security Basics');
        $article4->setSubtitle('Understanding security in Symfony applications.');
        $article4->setDateCreated(new \DateTimeImmutable('2023-10-04'));
        $article4->setDateModifed(new \DateTimeImmutable('2023-10-04'));
        $article4->setTags("Security;Symfony;Web Development");
        $article4->setContent('<p>Security is a critical aspect of web development, and Symfony provides robust tools for it.</p>');
        $article4->setAuthor('Bob Brown');
        $article4->setVisible(true);
        $manager->persist($article4);

        $article5 = new Article();
        $article5->setTitle('Twig Templating in Symfony');
        $article5->setSubtitle('Using Twig for templating in Symfony applications.');
        $article5->setDateCreated(new \DateTimeImmutable('2023-10-05'));
        $article5->setDateModifed(new \DateTimeImmutable('2023-10-05'));
        $article5->setTags("Twig;Templating;Symfony");
        $article5->setContent('<p>Twig is a modern templating engine for PHP that integrates seamlessly with Symfony.</p>');
        $article5->setAuthor('Charlie Green');
        $article5->setVisible(false);
        $manager->persist($article5);

        $article6 = new Article();
        $article6->setTitle('Testing Symfony Applications');
        $article6->setSubtitle('A guide to testing in Symfony using PHPUnit.');
        $article6->setDateCreated(new \DateTimeImmutable('2023-10-06'));
        $article6->setDateModifed(new \DateTimeImmutable('2023-10-06'));
        $article6->setTags("Testing;PHPUnit;Symfony");
        $article6->setContent('<p>Testing is essential for maintaining code quality, and Symfony provides excellent support for it.</p>');
        $article6->setAuthor('David Black');
        $article6->setVisible(true);
        $manager->persist($article6);

        $manager->flush();
    }
}
