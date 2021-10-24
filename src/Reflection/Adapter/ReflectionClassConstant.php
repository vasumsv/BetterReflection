<?php

declare(strict_types=1);

namespace Roave\BetterReflection\Reflection\Adapter;

use ReflectionClassConstant as CoreReflectionClassConstant;
use Roave\BetterReflection\Reflection\ReflectionAttribute as BetterReflectionAttribute;
use Roave\BetterReflection\Reflection\ReflectionClassConstant as BetterReflectionClassConstant;

use function array_map;

final class ReflectionClassConstant extends CoreReflectionClassConstant
{
    public function __construct(private BetterReflectionClassConstant $betterClassConstant)
    {
    }

    /**
     * Get the name of the reflection (e.g. if this is a ReflectionClass this
     * will be the class name).
     */
    public function getName(): string
    {
        return $this->betterClassConstant->getName();
    }

    /**
     * Returns constant value
     *
     * @return scalar|array<scalar>|null
     */
    public function getValue(): string|int|float|bool|array|null
    {
        return $this->betterClassConstant->getValue();
    }

    /**
     * Constant is public
     */
    public function isPublic(): bool
    {
        return $this->betterClassConstant->isPublic();
    }

    /**
     * Constant is private
     */
    public function isPrivate(): bool
    {
        return $this->betterClassConstant->isPrivate();
    }

    /**
     * Constant is protected
     */
    public function isProtected(): bool
    {
        return $this->betterClassConstant->isProtected();
    }

    /**
     * Returns a bitfield of the access modifiers for this constant
     */
    public function getModifiers(): int
    {
        return $this->betterClassConstant->getModifiers();
    }

    /**
     * Get the declaring class
     */
    public function getDeclaringClass(): ReflectionClass
    {
        return new ReflectionClass($this->betterClassConstant->getDeclaringClass());
    }

    /**
     * Returns the doc comment for this constant
     */
    public function getDocComment(): string|false
    {
        return $this->betterClassConstant->getDocComment() ?: false;
    }

    /**
     * To string
     *
     * @link https://php.net/manual/en/reflector.tostring.php
     */
    public function __toString(): string
    {
        return $this->betterClassConstant->__toString();
    }

    /**
     * @param class-string|null $name
     *
     * @return list<ReflectionAttribute>
     */
    public function getAttributes(?string $name = null, int $flags = 0): array
    {
        if ($name !== null && $flags & ReflectionAttribute::IS_INSTANCEOF) {
            $attributes = $this->betterClassConstant->getAttributesByInstance($name);
        } elseif ($name !== null) {
            $attributes = $this->betterClassConstant->getAttributesByName($name);
        } else {
            $attributes = $this->betterClassConstant->getAttributes();
        }

        return array_map(static fn (BetterReflectionAttribute $betterReflectionAttribute): ReflectionAttribute => new ReflectionAttribute($betterReflectionAttribute), $attributes);
    }

    public function isFinal(): bool
    {
        return $this->betterClassConstant->isFinal();
    }

    public function isEnumCase(): bool
    {
        throw new Exception\NotImplemented('Not implemented');
    }
}
