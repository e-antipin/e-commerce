<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Event\EventDispatcher;
use App\User\Domain\Aggregate\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private readonly EventDispatcher $dispatcher)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        $this->dispatcher->dispatch(...$user->releaseEvents());
    }

    public function findByUuid(Uuid $uuid): ?User
    {
        return $this->find($uuid);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
