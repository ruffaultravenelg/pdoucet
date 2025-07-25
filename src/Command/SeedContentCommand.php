<?php

namespace App\Command;

use App\Service\ContentLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'refresh:content',
    description: 'Insère les contenus statiques dans la base de données.',
)]
class SeedContentCommand extends Command
{
    public function __construct(private ContentLoader $loader) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'erase',
                InputArgument::OPTIONAL,
                'Erase existing content before inserting new ones (true/false)',
                'false'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $erase = filter_var($input->getArgument('erase'), FILTER_VALIDATE_BOOLEAN);
        $this->loader->updateDB($erase);
        $output->writeln('<info>Contenu inséré depuis le fichier YAML.</info>');
        return Command::SUCCESS;
    }

}
