<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Content('index.quote', '"Notre temps a besoin d’êtres qui soient comme des arbres, emplis d’une paix qui s’enracine dans la terre et le ciel."'));
        $manager->persist(new Content('index.quote.author', 'Olivier Clément'));
        $manager->persist(new Content('fullname', 'Pascal Doucet'));
        $manager->persist(new Content('index.introduction', 'Nous vivons une époque singulière, ô combien anxiogène de par les défis auxquels nous sommes confrontés, mais c’est aussi une époque qui nous oblige à nous réinventer, avec a minima, la perspective du réenchantement de notre existence, et pourquoi pas, à notre niveau, participer à réenchanter notre monde et à bâtir une nouvelle humanité fondée sur d’autres valeurs.<br/><br/>Le monde « développé » a atteint un tel niveau de « performance » qu’il nous est impossible de l’appréhender, tant dans les domaines de la technologie que des sciences. Et pourtant, force est de constater que le mal-être va grandissant, et que pour ce qui est de la santé, malgré les progrès médicaux, malgré l’énergie et le savoir-faire que déploient les soignants, il est bien difficile, à ces derniers, de répondre à des besoins de plus en plus aigus - souffrances psychiques de multiples origines, maladies de civilisation dues à la malbouffe, au stress, à la pollution… - d’autant que les moyens alloués aux services publics de la santé s’amenuisent.', 'text'));
        $manager->flush();
    }
}
