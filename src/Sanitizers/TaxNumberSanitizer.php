<?php

declare(strict_types=1);

namespace XimkiVinki\ValueObjects\Sanitizers;

use Illuminate\Support\Str;

class TaxNumberSanitizer
{
    /**
     * @param  string|null  $taxNumber
     * @param  string|null  $country
     *
     * @return string
     */
    public function sanitize(?string $taxNumber = null, ?string $country = null): string
    {
        $taxNumber = Str::upper(
            preg_replace('/[^\d\w]/', '', (string) $taxNumber) ?? ''
        );
        $country = Str::upper((string) $country);

        if (blank($country)) {
            return $taxNumber;
        }

        $string = str($taxNumber);

        return ($string->startsWith($country)
            ? $string->substr(2)->start($country)
            : $string->start($country)
        )->toString();
    }
}
