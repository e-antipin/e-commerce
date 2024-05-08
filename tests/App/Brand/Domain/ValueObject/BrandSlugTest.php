<?php

namespace Tests\App\Brand\Domain\ValueObject;

use App\Shop\Brand\Domain\Exception\BrandSlugException;
use App\Shop\Brand\Domain\ValueObject\BrandSlug;
use PHPUnit\Framework\TestCase;

class BrandSlugTest  extends TestCase
{
    final public const BAD_URL = 'Не верный юрл';
    final public const GOOD_SLUG = "ne-verny-i-yurl";

    /**
     * @test
     *
     * @group unit
     *
     * @throws BrandSlugException
     */
    public function given_a_bad_formatted_string_it_should_throw_an_exception_when_we_try_to_create_brand_slug(): void
    {
        $this->expectException(BrandSlugException::class);
        new BrandSlug(self::BAD_URL);
    }

    /**
     * @test
     *
     * @group unit
     *
     */
    public function given_a_good_formatted_string_when_we_try_to_create_brand_slug(): void
    {
        $slug = BrandSlug::convert(self::BAD_URL);

        $this->assertEquals($slug->value(), self::GOOD_SLUG);
    }

    /**
     * @test
     *
     * @group unit
     *
     */
    public function given_a_good_formatted_string_when_we_try_to_create_next_brand_slug(): void
    {
        $slug = BrandSlug::convert(self::BAD_URL);
        $slug->next();
        $this->assertEquals($slug->value(), self::GOOD_SLUG. '-1');

        $slug = BrandSlug::convert(self::BAD_URL . '-2');
        $slug->next();
        $this->assertEquals($slug->value(), self::GOOD_SLUG. '-3');
    }
}