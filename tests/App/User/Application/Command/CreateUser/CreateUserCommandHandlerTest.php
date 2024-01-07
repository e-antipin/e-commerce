<?php

namespace Tests\App\User\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\User\Application\Command\CreateUser\CreateUserCommand;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\HashedPassword;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateUserCommandHandlerTest extends WebTestCase
{
    private Generator $faker;
    private $commandBus;
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
        $this->userRepository = $this::getContainer()->get(UserRepositoryInterface::class);
    }

    public function test_user_created_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();

        $command = new CreateUserCommand(new Credentials(\App\User\Domain\ValueObject\Email::fromString($email),HashedPassword::toHash($password)));
        $newUserUuid = $this->commandBus->execute($command);

        $user = $this->userRepository->findByUuid($newUserUuid);
        $this->assertNotEmpty($user);
    }
}
