<?php

namespace Tests\App\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     */
    public function bad_convert_uuid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $stringUuid = '324234';
        $uuid = new Uuid($stringUuid);
    }

    /**
     * @test
     *
     * @group unit
     */
    public function good_convert_uuid(): void
    {
        $stringUuid = '253e0f90-8842-4731-91dd-0191816e6a28';
        $uuid = new Uuid($stringUuid);

        $this->assertEquals($uuid->value(), $stringUuid);
        $this->assertTrue($uuid->equals(new Uuid($stringUuid)));
    }
}
