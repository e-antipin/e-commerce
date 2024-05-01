<?php

declare(strict_types=1);

namespace App\Brand\Domain\Specification;

use App\Brand\Domain\Aggregate\Brand;
use App\Brand\Domain\ValueObject\BrandSlug;

interface UniqueSlugSpecificationInterface
{
    public function isUnique(BrandSlug $slug): void;
}