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

use Illuminate\Support\Stringable;
use XimkiVinki\ValueObjects\Collection\Primitive\Text;
use XimkiVinki\ValueObjects\Sanitizers\NameSanitizer;

/**
 * "Name" object presenting a generic name.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string|Stringable $value)
 * @method static static from(string|Stringable $value)
 * @method static static makeOrNull(string|Stringable|null $value)
 *
 * @extends Text<TKey, TValue>
 */
class Name extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->sanitize();
    }

    /**
     * Sanitize the value.
     *
     * @return void
     */
    protected function sanitize(): void
    {
        $this->value = (new NameSanitizer)->sanitize($this->value());
    }
}
