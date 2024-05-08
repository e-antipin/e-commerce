<?php

declare(strict_types=1);

namespace App\Shop\Brand\Domain\Exception;

class BrandSlugException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Brand slug is not valid');
    }
}