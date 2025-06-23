<?php

namespace App\Command;

use App\Entity\Content;
use App\Service\ContentLoader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(
    name: 'refresh:content',
    description: 'Insère les contenus statiques dans la base de données.',
)]
class SeedContentCommand extends Command
{
    public function __construct(private EntityManagerInterface $em, private ContentLoader $loader) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->em->createQuery('DELETE FROM App\Entity\Content')->execute();

        foreach ($this->loader->loadFromYaml() as $content) {
            $this->em->persist($content);
        }

        $this->em->flush();
        $output->writeln('<info>Contenu inséré depuis le fichier YAML.</info>');

        return Command::SUCCESS;
    }

}
