<?php

namespace App\Tests\Command;

use App\Command\IncreaseAgesCommand;
use App\Entity\Classification;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class IncreaseAgesTest extends KernelTestCase
{

    public static function setUpBeforeClass(): void
    {

        self::bootKernel();
        self::clearDB();
        self::addUsers();
    }

    private static function clearDB(): void
    {

        self::getContainer()
            ->get(PersonRepository::class)
            ->createQueryBuilder('person')
            ->delete()
            ->getQuery()
            ->execute();
    }

    private static function addUsers(): void
    {

        $em = self::getContainer()->get('doctrine.orm.entity_manager');
        $em->persist(new Person(Classification::CHILD, 'James Doe', 10));
        $em->persist(new Person(Classification::CHILD, 'James Doe', 17));
        $em->persist(new Person(Classification::ADULT, 'James Doe', 20));
        $em->flush();
    }

    public function testIncreaseAges(): void
    {

        self::bootKernel();
        $command = self::getContainer()->get(IncreaseAgesCommand::class);
        $command->setApplication(new Application());

        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([]);
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }


    public static function tearDownAfterClass(): void
    {

        self::clearDB();
    }
}
