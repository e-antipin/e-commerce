<?php

namespace Tests\App\User\Domain\ValueObject;

use App\User\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class EmailTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     *
     * @throws InvalidArgumentException
     */
    public function invalid_email_should_throw_an_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('asd');
    }

    /**
     * @test
     *
     * @group unit
     *
     * @throws InvalidArgumentException
     */
    public function valid_email_should_be_able_to_convert_to_string(): void
    {
        $email = Email::fromString('an@email.com');

        self::assertSame('an@email.com', $email->toString());
        self::assertSame('an@email.com', (string) $email);
    }
}
