<?php

declare(strict_types=1);

/**
 * This file is part of ximki-vinki/laravel-value-objects. (https://github.com/ximki-vinki/laravel-value-objects)
 *
 * @link https://github.com/ximki-vinki/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/ximki-vinki/laravel-value-objects/main/LICENSE.md MIT
 */

namespace XimkiVinki\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;
use XimkiVinki\ValueObjects\Concerns\HandlesCallbacks;
use XimkiVinki\ValueObjects\Contracts\Immutable;
use Throwable;

/**
 * Base "ValueObject".
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements Arrayable<TKey, TValue>
 */
abstract class ValueObject implements Arrayable, Immutable, \Stringable
{
    use Conditionable, HandlesCallbacks, Macroable;

    private bool $constructed = false;

    /**
     * Create a new instance of the value object.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        if ($this->constructed) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->constructed = true;
    }

    /**
     * Get the object value.
     *
     * @return mixed
     */
    abstract public function value();

    /**
     * Convenient method to create a value object statically.
     *
     *
     * @return static
     */
    public static function make(mixed ...$values): static
    {
        return new static(...$values);
    }

    /**
     * Convenient method to create a value object statically.
     *
     *
     * @return static
     */
    public static function from(mixed ...$values): static
    {
        return static::make(...$values);
    }

    /**
     * Create a value object or return null.
     *
     *
     * @return static|null
     */
    public static function makeOrNull(mixed ...$values): ?static
    {
        try {
            return static::make(...$values);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Check if objects are instances of same class
     * and share the same properties and values.
     *
     * @param  ValueObject<int|string, mixed>  $object
     *
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this == $object;
    }

    /**
     * Inversion for `equals` method.
     *
     * @param  ValueObject<int|string, mixed>  $object
     *
     * @return bool
     */
    public function notEquals(ValueObject $object): bool
    {
        return ! $this->equals($object);
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this->value();
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function toString(): string
    {
        return (string) $this->value();
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Get the internal property value.
     *
     * @param  string  $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->{$name};
    }

    /**
     * Make sure value object is immutable.
     *
     * @param  string  $name
     * @param  mixed  $value
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function __set(string $name, mixed $value): void
    {
        throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
    }
}
