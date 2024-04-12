<?php

use BradieTilley\FakerCatz\Catz;
use Illuminate\Support\Collection;

test('catz helper function loads a singleton instance of Catz', function () {
    expect(catz())->toBeInstanceOf(Catz::class);
    expect(catz())->toBe(catz());
});

test('catz can load all cat pics', function () {
    $min = 1;
    $max = 120;

    $expect = Collection::range($min, $max)
        ->map(fn (int $i) => 'cat_'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg')
        ->map(fn (string $name) => Catz::absolutePath($name))
        ->values()
        ->all();

    /**
     * All is representative of what's in the pics directory
     */
    $actual = catz()->all();
    expect($actual)->toBe($expect);
});
