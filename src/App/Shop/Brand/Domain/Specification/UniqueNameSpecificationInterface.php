<?php

declare(strict_types=1);

namespace App\Shop\Brand\Domain\Specification;

use App\Shop\Brand\Domain\ValueObject\BrandName;

interface UniqueNameSpecificationInterface
{
    public function isUnique(BrandName $name): void;
}