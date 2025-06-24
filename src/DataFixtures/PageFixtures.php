<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $page1 = new Page();
        $page1->setSlug('prestations');
        $page1->setName('Prestations');
        $page1->setSubtitle('Welcome to our website');
        $page1->setCreationDate(new \DateTimeImmutable('2023-10-01'));
        $page1->setLastModificationDate(new \DateTimeImmutable('2023-10-01'));
        $page1->setContent('<p>We offer a wide range of services to meet your needs.</p>');
        $manager->persist($page1);

        $page2 = new Page();
        $page2->setSlug('about-us');
        $page2->setName('About Us');
        $page2->setSubtitle('Learn more about our company');
        $page2->setCreationDate(new \DateTimeImmutable('2023-10-02'));
        $page2->setLastModificationDate(new \DateTimeImmutable('2023-10-02'));
        $page2->setContent('<p>Our company has been serving customers for over a decade.</p>');
        $manager->persist($page2);

        $page3 = new Page();
        $page3->setSlug('contact');
        $page3->setName('Contact');
        $page3->setSubtitle('Get in touch with us');
        $page3->setCreationDate(new \DateTimeImmutable('2023-10-03'));
        $page3->setLastModificationDate(new \DateTimeImmutable('2023-10-03'));
        $page3->setContent('<p>Contact us via email or phone for more information.</p>');
        $manager->persist($page3);

        $page4 = new Page();
        $page4->setSlug('faq');
        $page4->setName('FAQ');
        $page4->setSubtitle('Frequently Asked Questions');
        $page4->setHeaderImage('crevette.gif');
        $page4->setCreationDate(new \DateTimeImmutable('2023-10-04'));
        $page4->setLastModificationDate(new \DateTimeImmutable('2023-10-04'));
        $page4->setContent('<p>Find answers to common questions about our services.</p>');
        $manager->persist($page4);

        $manager->flush();
    }
}
