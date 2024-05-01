<?php

declare(strict_types=1);

namespace UI\Cli;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use App\User\Application\UseCase\Command\SignUp\SignUpCommand;
use App\User\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:test',
)]
final class TestConsoleCommand extends Command
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uuid = Uuid::new();
        $command = new SignUpCommand($uuid->value(), 'test@test.com', 'password');

        // act
        $this->commandBus->execute($command);

        $user = $this->users->findByUuid($uuid);

        if ($user !== null) {
            $output->writeln($user->uuid());
        }

        return Command::SUCCESS;
    }
}
