<?php

declare(strict_types=1);

namespace App\Shop\Brand\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValue;
use App\Shop\Brand\Domain\Exception\BrandSlugException;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class BrandSlug extends StringValue
{
    const SLUG_SEPARATOR = '-';
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
        $slug = $slugger->slug($value)->lower();

        return new self((string)$slug);
    }

    public function next()
    {
        $slug = $this->value();
        $position = strrpos( $slug,self::SLUG_SEPARATOR);
        $i = 1;

        if ($position !== false) {

            if ( ($suffix = (int)substr($slug, $position + 1)) > 0 )
                $slug = substr($slug,0,$position);
            $i = $suffix + 1;
        }
        $this->value = $slug . self::SLUG_SEPARATOR . $i;
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