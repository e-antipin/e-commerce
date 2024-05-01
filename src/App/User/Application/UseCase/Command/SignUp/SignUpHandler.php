<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\Command\SignUp;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Exception\DateTimeException;
use App\User\Domain\Factory\UserFactory;
use App\User\Domain\Repository\UserRepositoryInterface;

final class SignUpHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository, private readonly UserFactory $userFactory)
    {
    }

    /**
     * @throws DateTimeException
     */
    public function __invoke(SignUpCommand $command): void
    {
        $user = $this->userFactory->create($command->uuid, $command->credentials);
        $this->userRepository->add($user);
    }
}
