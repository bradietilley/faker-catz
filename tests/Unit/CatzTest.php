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

    /**
     * Pool is not the same as all as it's shuffled
     */
    expect(catz()->pool())->toHaveCount(count($actual))->not->toBe($actual);

    /**
     * The pool contains the same images just in wrong order
     */
    $poolSorted = collect(catz()->pool())->sort()->values()->all();
    expect($poolSorted)->toBe($expect);

    $random = [];
    while (count($random) < count($actual)) {
        $random[] = catz()->path();
    }
    expect($random)->not->toBe($expect);
    $randomSorted = collect($random)->sort()->values()->all();
    expect($randomSorted)->toBe($expect);

    expect(catz()->pool())->toBe([]);

    $temp = catz()->path();

    /**
     * Auto refeed
     */
    expect(catz()->pool())->toHaveCount(count($expect) - 1);

    $random2 = [$temp];
    while (count($random2) < count($actual)) {
        $random2[] = catz()->path();
    }
    expect($random2)->not->toBe($expect);
    $random2Sorted = collect($random2)->sort()->values()->all();
    expect($random2Sorted)->toBe($expect);
});

test('catz can seed consistent results', function () {
    /**
     * Pools are randomised each time it's loaded by default
     */
    expect(catz()->load()->pool())->not->toBe(catz()->load()->pool());

    catz()->seed(4353454536);

    mt_srand(3453578934543);
    $expect = mt_rand(100, 1000);
    mt_srand(); // reset

    mt_srand(3453578934543);
    $actual = mt_rand(100, 1000);
    mt_srand(); // reset

    if ($expect !== $actual) {
        // We're dealing with an env that doesn't support mt_srand
        $this->markTestSkipped('mt_srand does not work');

        return;
    }

    // Otherwise mt_srand works

    /**
     * Pools are randomised using the seed and thus aren't random anymore
     */
    expect(catz()->load()->pool())->toBe(catz()->load()->pool());
});
