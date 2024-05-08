<?php

namespace App\Shop\Brand\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Exception\DateTimeException;
use App\Shared\Domain\ValueObject\DateTime;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shop\Brand\Domain\Service\BrandSlugGeneratorInterface;
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

    private DateTime $createdAt;

    private ?DateTime $updatedAt = null;


    private function __construct(Uuid $uuid, BrandName $name, BrandDescription $description, BrandSlug $slug){
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
    }

    /**
     * @throws DateTimeException
     */
    public static function create(
        Uuid $uuid,
        BrandName $name,
        BrandDescription $description,
        BrandSlugGeneratorInterface $slugGenerator,
        UniqueNameSpecificationInterface $uniqueNameSpecification,
    ): self
    {
        $uniqueNameSpecification->isUnique($name);
        $slug = $slugGenerator->slugify($name);

        $brand = new self($uuid, $name, $description, $slug);
        $brand->createdAt = DateTime::now();
        $brand->updatedAt = DateTime::now();

        return $brand;
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