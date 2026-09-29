<?php

declare(strict_types=1);

/**
 * This file is part of ximki-vinki/laravel-value-objects. (https://github.com/ximki-vinki/laravel-value-objects)
 *
 * @link https://github.com/ximki-vinki/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/ximki-vinki/laravel-value-objects/main/LICENSE.md MIT
 */

namespace XimkiVinki\ValueObjects\Collection\Complex;

use Illuminate\Validation\ValidationException;
use XimkiVinki\ValueObjects\ValueObject;

/**
 * "Uuid" object presenting unique ID.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @method static static make(string $value, string|null $name = null)
 * @method static static from(string $value, string|null $name = null)
 * @method static static makeOrNull(string|null $value, string|null $name = null)
 */
class Uuid extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string  $value
     * @param  string|null  $name
     */
    public function __construct(protected string $value, protected ?string $name = null)
    {
        parent::__construct();

        $this->validate();
    }

    /**
     * Get the UUID value.
     *
     * @return string
     */
    public function uuid(): string
    {
        return $this->value();
    }

    /**
     * Get the UUID name if present.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->name(),
            'value' => $this->value(),
        ];
    }

    /**
     * Validate the value object data.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (! str($this->value())->isUuid()) {
            throw ValidationException::withMessages(['UUID is invalid.']);
        }
    }
}
