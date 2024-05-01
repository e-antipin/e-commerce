<?php

declare(strict_types=1);

namespace App\Brand\Domain\ValueObject;

use App\Brand\Domain\Exception\BrandSlugException;
use App\Shared\Domain\ValueObject\StringValue;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class BrandSlug extends StringValue
{
    /**
     * @throws BrandSlugException
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    public static function convert(string $value): StringValue
    {
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($value);

        return new self((string)$slug);
    }

    /**
     * @throws BrandSlugException
     */
    private function validate($value):void
    {
        if (!preg_match('/^[a-z0-9]+(-?[a-z0-9]+)*$/i', $value)) {
            throw new BrandSlugException();
        }
    }
}