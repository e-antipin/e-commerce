<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Domain\ValueObject\Uuid;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class UuidType extends Type
{
    public const NAME = 'uuid_binary';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL(
            [
                'length' => 32,
                'fixed' => true,
            ],
        );
    }

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            $uuid = Uuid::fromBytes(stream_get_contents($value));
        } catch (\Throwable $e) {
            throw new ConversionException(self::NAME);
        }

        return $uuid;
    }

    /**
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Uuid) {
            return $value->toBytes();
        }

        if (null === $value || '' === $value) {
            return null;
        }

        try {
            if (is_string($value) || (is_object($value) && method_exists($value, '__toString'))) {
                return (new Uuid((string) $value))->value();
            }
        } catch (\Throwable $e) {
            // Ignore the exception and pass through.
        }

        throw ConversionException::conversionFailed($value, self::NAME);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getBindingType(): ParameterType
    {
        return ParameterType::BINARY;
    }
}
