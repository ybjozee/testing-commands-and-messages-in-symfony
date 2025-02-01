<?php

namespace App\Command;

use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:increase-ages',
    description: 'Add a short description for your command',
)]
class IncreaseAgesCommand extends Command
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private PersonRepository       $personRepository,
    )
    {

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $people = $this->personRepository->findAll();

        foreach ($people as $person) {
            $age = $person->getAge();
            $person->setAge(++$age);
            $this->entityManager->persist($person);
        }

        $this->entityManager->flush();

        $io = new SymfonyStyle($input, $output);
        $io->success('All ages increased successfully!');

        return Command::SUCCESS;
    }
}
