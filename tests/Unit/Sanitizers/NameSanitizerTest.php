<?php

declare(strict_types=1);

use XimkiVinki\ValueObjects\Sanitizers\NameSanitizer;

test('sanitizes names', function (?string $input, string $expected) {
    expect((new NameSanitizer)->sanitize($input))->toBe($expected);
})->with([
    'trims and squashes spaces' => ['      Test Name     ', 'Test Name'],
    'removes literal unix escape sequences' => [' Test\r\n\t Name ', 'Test Name'],
    'removes real control characters' => ["Test\nName", 'TestName'],
    'keeps punctuation and symbols' => ['Name@$', 'Name@$'],
    'collapses multiline company names' => [
        "HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,\nTAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI",
        'HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,TAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI',
    ],
    'removes literal \r\n inside text' => [
        'HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,\r\nTAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI',
        'HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,TAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI',
    ],
    'empty string stays empty' => ['', ''],
    'whitespace-only becomes empty' => ['   ', ''],
    'null becomes empty' => [null, ''],
]);

test('sanitizes full names', function (?string $input, string $expected) {
    expect((new NameSanitizer)->sanitizeFull($input))->toBe($expected);
})->with([
    'ucfirst single word' => ['michael', 'Michael'],
    'ucfirst unicode last name' => ['rubél', 'Rubél'],
    'ucfirst first and last name' => ['michael rubél', 'Michael Rubél'],
    'preserves existing inner capitals' => ['michael mcKenzie', 'Michael McKenzie'],
    'keeps hyphenated last name casing quirks' => [' anna nowak-kowalska ', 'Anna Nowak-kowalska'],
    'trims surrounding spaces' => [' Michael Rubél ', 'Michael Rubél'],
    'treats real newlines as word separators' => ["Test Full \nName", 'Test Full Name'],
    'empty string stays empty' => ['', ''],
    'whitespace-only becomes empty' => ['   ', ''],
    'null becomes empty' => [null, ''],
]);
