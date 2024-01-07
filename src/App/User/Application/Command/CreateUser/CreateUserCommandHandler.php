<?php

declare(strict_types=1);

namespace App\User\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return string UserId
     */
    public function __invoke(CreateUserCommand $createUserCommand): string
    {
        $user = User::create($createUserCommand->credentials);
        $this->userRepository->add($user);
        return $user->getUuid();
    }

}