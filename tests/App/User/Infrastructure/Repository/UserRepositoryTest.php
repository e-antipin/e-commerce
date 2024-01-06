<?php

namespace Tests\App\User\Infrastructure\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use PharIo\Manifest\Email;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->faker = Factory::create();
    }

    public function test_user_added_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();

        $user = User::create(new Credentials(\App\User\Domain\ValueObject\Email::fromString($email),HashedPassword::toHash($password)));

        $this->repository->add($user);

        $existUser = $this->repository->findByUuid($user->getUuid());
        $this->assertEquals($user->getUuid(), $existUser->getUuid());

    }
}
