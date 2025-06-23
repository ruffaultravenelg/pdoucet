<?php

namespace App\Command;

use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:seed-content',
    description: 'Insère les contenus statiques dans la base de données.',
)]
class SeedContentCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contents = [
            new Content('index.quote', '"Notre temps a besoin d’êtres qui soient comme des arbres, emplis d’une paix qui s’enracine dans la terre et le ciel."'),
            new Content('index.quote.author', 'Olivier Clément'),
            new Content('fullname', 'Pascal Doucet'),
            new Content('index.introduction', 'Nous vivons une époque singulière [...]', 'text'),
        ];

        foreach ($contents as $content) {
            $this->em->persist($content);
        }

        $this->em->flush();

        $output->writeln('<info>Contenu inséré avec succès.</info>');

        return Command::SUCCESS;
    }
}
