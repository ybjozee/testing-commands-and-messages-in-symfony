<?php

namespace App\Tests\Message;

use App\Entity\Classification;
use App\Message\CreatePerson;
use App\Repository\PersonRepository;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use Zenstruck\Messenger\Test\Transport\TestTransport;

class CreatePersonTest extends KernelTestCase {

    use InteractsWithMessenger;

    public static function setUpBeforeClass()
    : void {

        self::bootKernel();
        self::clearDB();
    }

    private static function clearDB()
    : void {

        self::getContainer()
            ->get(PersonRepository::class)
            ->createQueryBuilder('person')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public static function tearDownAfterClass()
    : void {

        self::clearDB();
        TestTransport::resetAll();
    }

    public static function providePersonData()
    : Generator {

        yield ['Jane Doe', 15, Classification::CHILD];
        yield ['Jane Doe', 20, Classification::ADULT];
    }

    #[DataProvider('providePersonData')]
    public function testCreatePerson(string $name, int $age, Classification $classification)
    : void {

        $this->transport('async')->send(new CreatePerson($name, $age));
        $this->transport('async')->processOrFail();
        $this->transport('async')->queue()->assertEmpty();

        /**@var PersonRepository $repository */
        $repository = self::getContainer()->get(PersonRepository::class);

        $savedPerson = $repository->findOneBy(['name' => $name, 'age' => $age, 'classification' => $classification]);
        $this->assertNotNull($savedPerson, "Expected $classification->value '$name' not found");
    }
}
