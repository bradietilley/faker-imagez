<?php

use Illuminate\Support\Collection;
use Tests\Fixtures\Examplez;

test('examplez helper function loads a singleton instance of examplez', function () {
    expect(examplez())->toBeInstanceOf(Examplez::class);
    expect(examplez())->toBe(examplez());
});

test('examplez can load all cat pics', function () {
    $min = 1;
    $max = 9;

    $expect = Collection::range($min, $max)
        ->map(fn (int $i) => 'cat_'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg')
        ->map(fn (string $name) => Examplez::absolutePath($name))
        ->values()
        ->all();

    /**
     * All is representative of what's in the pics directory
     */
    $actual = examplez()->all();
    expect($actual)->toBe($expect);

    /**
     * Pool is not the same as all as it's shuffled
     */
    expect(examplez()->pool())->toHaveCount(count($actual))->not->toBe($actual);

    /**
     * The pool contains the same images just in wrong order
     */
    $poolSorted = collect(examplez()->pool())->sort()->values()->all();
    expect($poolSorted)->toBe($expect);

    $random = [];
    while (count($random) < count($actual)) {
        $random[] = examplez()->path();
    }
    expect($random)->not->toBe($expect);
    $randomSorted = collect($random)->sort()->values()->all();
    expect($randomSorted)->toBe($expect);

    expect(examplez()->pool())->toBe([]);

    $temp = examplez()->path();

    /**
     * Auto refeed
     */
    expect(examplez()->pool())->toHaveCount(count($expect) - 1);

    $random2 = [$temp];
    while (count($random2) < count($actual)) {
        $random2[] = examplez()->path();
    }
    expect($random2)->not->toBe($expect);
    $random2Sorted = collect($random2)->sort()->values()->all();
    expect($random2Sorted)->toBe($expect);
});
