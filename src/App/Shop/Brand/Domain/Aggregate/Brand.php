<?php

namespace App\Shop\Brand\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shop\Brand\Domain\Specification\UniqueNameSpecificationInterface;
use App\Shop\Brand\Domain\Specification\UniqueSlugSpecificationInterface;
use App\Shop\Brand\Domain\ValueObject\BrandDescription;
use App\Shop\Brand\Domain\ValueObject\BrandName;
use App\Shop\Brand\Domain\ValueObject\BrandSlug;

class Brand extends AggregateRoot
{
    private Uuid $uuid;

    private BrandName $name;

    private BrandDescription $description;

    private BrandSlug $slug;

    private function __construct(Uuid $uuid, BrandName $name, BrandDescription $description, BrandSlug $slug){
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
    }

    public static function create(
        Uuid $uuid,
        BrandName $name,
        BrandDescription $description,
        BrandSlug $slug,
        UniqueSlugSpecificationInterface $uniqueSlugSpecification,
        UniqueNameSpecificationInterface $uniqueNameSpecification,
    ): self
    {
        $uniqueNameSpecification->isUnique($name);
        $uniqueSlugSpecification->isUnique($slug);

        return new self($uuid, $name, $description, $slug);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function description(): string
    {
        return $this->description->value();
    }

    public function slug(): string
    {
        return $this->slug->value();
    }
}