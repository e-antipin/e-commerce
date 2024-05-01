<?php

namespace Tests\App\User\Domain\ValueObject;

use App\User\Domain\ValueObject\HashedPassword;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class HashedPasswordTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     */
    public function encoded_password_should_be_validated(): void
    {
        $pass = HashedPassword::toHash('1234567890');

        self::assertTrue($pass->match('1234567890'));
    }

    /**
     * @test
     *
     * @group unit
     */
    public function password_min_length()
    {
        $this->expectException(InvalidArgumentException::class);
        HashedPassword::toHash('12345');
    }

    /**
     * @test
     *
     * @group unit
     */
    public function from_hash_password_should_still_valid(): void
    {
        $pass = HashedPassword::fromHash((string) HashedPassword::toHash('1234567890'));

        self::assertTrue($pass->match('1234567890'));
    }
}
