<?php

declare(strict_types=1);

namespace App\Shop\Brand\Domain\Specification;

use App\Shop\Brand\Domain\ValueObject\BrandSlug;

interface UniqueSlugSpecificationInterface
{
    public function isUnique(BrandSlug $slug): void;
}