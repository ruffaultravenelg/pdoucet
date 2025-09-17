<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product();
        $product1->setName('Service de Consultation');
        $product1->setDescription('Une consultation approfondie pour vos besoins spécifiques.');
        $product1->setImage('https://cdn.cultura.com/cdn-cgi/image/width=830/media/pim/TITELIVE/77_9782014627473_1_75.jpg');
        $product1->setRequestForm(true);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Atelier de Formation');
        $product2->setDescription('Participez à notre atelier interactif pour améliorer vos compétences.');
        $product2->setImage('https://images.renaud-bray.com/images/PG/1394/1394564-gf.jpg?404=404RB.gif');
        $product2->setRequestForm(true);
        $manager->persist($product2);

        $manager->flush();
    }
}
