<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    public function __construct(
        #[ORM\Column]
        private Classification $classification,
        #[ORM\Column]
        private string         $name,
        #[ORM\Column]
        private int            $age,
    )
    {

        $this->checkAgeAndClassification($age, $classification);
    }

    private function checkAgeAndClassification(int $age, Classification $classification): void
    {

        if (Classification::getClassification($age) !== $classification) {
            throw new Exception('Specified age does not satisfy classification criteria');
        }
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {

        $this->age = $age;
        $this->classification = Classification::getClassification($age);
        $this->checkAgeAndClassification($this->age, $this->classification);
    }
}
