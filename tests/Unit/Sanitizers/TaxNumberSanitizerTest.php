<?php

declare(strict_types=1);

use MichaelRubel\ValueObjects\Sanitizers\TaxNumberSanitizer;

test('sanitizes tax numbers', function (?string $taxNumber, ?string $country, string $expected) {
    expect((new TaxNumberSanitizer)->sanitize($taxNumber, $country))->toBe($expected);
})->with([
    'adds country prefix' => ['0123456789', 'UA', 'UA0123456789'],
    'uppercases country' => ['0123456789', 'pl', 'PL0123456789'],
    'empty country keeps number' => ['0123456789', '', '0123456789'],
    'null country keeps number' => ['0123456789', null, '0123456789'],
    'different country prefix is prepended' => ['FR0123456789', 'PL', 'PLFR0123456789'],
    'strips non-alphanumeric characters' => ['+01 23-45.67,89', 'pL', 'PL0123456789'],
    'does not duplicate matching prefix' => ['PL0123456789', 'pL', 'PL0123456789'],
    'uppercases number and country' => ['pL0123456789', 'pl', 'PL0123456789'],
    'empty data stays empty' => ['', '', ''],
    'country only' => [null, 'pL', 'PL'],
    'null number without country' => [null, null, ''],
    'null number with country' => [null, 'PL', 'PL'],
    'strips dashes' => ['526-10-40-567', 'PL', 'PL5261040567'],
    'strips spaced dashes' => [' 526- -10 -40- 567 ', 'PL', 'PL5261040567'],
    'strips dashes without country' => [' 526- 10 -40- 567 -', null, '5261040567'],
]);
