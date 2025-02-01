<?php

namespace App\MessageHandler;

use App\Entity\Classification;
use App\Entity\Person;
use App\Message\CreatePerson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreatePersonHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(CreatePerson $message): void
    {

        $name = $message->name;
        $age = $message->age;
        $classification = Classification::getClassification($age);

        $person = new Person($classification, $name, $age);

        $this->entityManager->persist($person);
        $this->entityManager->flush();
    }
}
