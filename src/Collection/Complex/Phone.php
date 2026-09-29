<?php

/**
 * This file is part of ximki-vinki/laravel-value-objects. (https://github.com/ximki-vinki/laravel-value-objects)
 *
 * @link https://github.com/ximki-vinki/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/ximki-vinki/laravel-value-objects/main/LICENSE.md MIT
 */

namespace XimkiVinki\ValueObjects\Collection\Complex;

use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use XimkiVinki\ValueObjects\Collection\Primitive\Text;

/**
 * "Phone" object that represents a telephone number.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @method static static make(string|Stringable $value)
 * @method static static from(string|Stringable $value)
 * @method static static makeOrNull(string|Stringable|null $value)
 */
class Phone extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->trim();
    }

    /**
     * Get the sanitized phone number.
     *
     * @return string
     */
    public function sanitized(): string
    {
        return str($this->value())
            ->replaceMatches('/\p{C}+/u', '')
            ->replace(' ', '')
            ->value();
    }

    /**
     * Validate the phone number.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (! preg_match('/^[+]?[0-9 ]{5,15}$/', $this->sanitized())) {
            throw ValidationException::withMessages(['Your phone number is invalid.']);
        }
    }

    /**
     * Trim the value.
     *
     * @return void
     */
    protected function trim(): void
    {
        $this->value = trim($this->value());
    }
}
