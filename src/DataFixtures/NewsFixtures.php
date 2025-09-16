<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $news1 = new News();
        $news1->setTitle('Nouvelle fonctionnalité');
        $news1->setContent('Nous avons ajouté une nouvelle fonctionnalité à notre application.');
        $news1->setDate(new \DateTimeImmutable('2024-06-01'));
        $manager->persist($news1);

        $news2 = new News();
        $news2->setTitle('Mise à jour de sécurité');
        $news2->setContent('Une mise à jour de sécurité importante a été déployée.');
        $news2->setDate(new \DateTimeImmutable('2024-06-15'));
        $manager->persist($news2);

        $news3 = new News();
        $news3->setTitle('Événement à venir');
        $news3->setContent('Rejoignez-nous pour notre événement annuel le mois prochain.');
        $news3->setDate(new \DateTimeImmutable('2024-07-10'));
        $manager->persist($news3);
        
        $news4 = new News();
        $news4->setTitle('Nouvelle fonctionnalité');
        $news4->setContent('Nous avons ajouté une nouvelle fonctionnalité à notre application.');
        $news4->setDate(new \DateTimeImmutable('2024-06-01'));
        $manager->persist($news4);

        $news5 = new News();
        $news5->setTitle('Mise à jour de sécurité');
        $news5->setContent('Une mise à jour de sécurité importante a été déployée.');
        $news5->setDate(new \DateTimeImmutable('2024-06-15'));
        $manager->persist($news5);

        $news6 = new News();
        $news6->setTitle('Événement à venir');
        $news6->setContent('Rejoignez-nous pour notre événement annuel le mois prochain.');
        $news6->setDate(new \DateTimeImmutable('2024-07-10'));
        $manager->persist($news6);

        $manager->flush();
    }
}
