<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Sanitizers;

class NameSanitizer
{
    /**
     * @param  string|null  $name
     *
     * @return string
     */
    public function sanitize(?string $name): string
    {
        return str($name)
            ->replaceMatches('/\p{C}+/u', '')
            ->replace(['\r', '\n', '\t'], '')
            ->squish()
            ->value();
    }

    /**
     * @param  string|null  $name
     *
     * @return string
     */
    public function sanitizeFull(?string $name): string
    {
        $formatted = str($name)
            ->split('/\s/')
            ->map(fn (string $word) => str($word)->ucfirst()->value())
            ->join(' ');

        return str($formatted)
            ->replaceMatches('/\p{C}+/u', '')
            ->squish()
            ->value();
    }
}
