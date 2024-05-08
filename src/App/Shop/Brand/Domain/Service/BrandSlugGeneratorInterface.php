<?php

namespace App\Shop\Brand\Domain\Service;

use App\Shop\Brand\Domain\ValueObject\BrandSlug;

interface BrandSlugGeneratorInterface
{
    public function slugify(string $value): BrandSlug;
}