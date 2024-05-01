<?php

namespace Tests\App\User\Application\Command\SignUp;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Application\Command\SignUp\SignUpCommand;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignUpHandlerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_created_successfully(): void
    {
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $uuid = Uuid::new();
        $command = new SignUpCommand($uuid->value(), 'test@test.com', 'password');
        // act
        $commandBus->execute($command);

        // assert
        $user = $userRepository->findByUuid($uuid);
        $this->assertNotEmpty($user);
    }
}
