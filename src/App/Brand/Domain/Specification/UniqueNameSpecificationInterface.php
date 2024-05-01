<?php

declare(strict_types=1);

namespace App\Brand\Domain\Specification;

use App\Brand\Domain\ValueObject\BrandName;

interface UniqueNameSpecificationInterface
{
    public function isUnique(BrandName $name): void;
}