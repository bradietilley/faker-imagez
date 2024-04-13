<?php

use Tests\Fixtures\CatSampleImagez;

test('examplez helper function loads a singleton instance of examplez', function () {
    expect(catSamplez())->toBeInstanceOf(CatSampleImagez::class);
    expect(catSamplez())->toBe(catSamplez());
});

test('examplez can load all cat pics', function () {
    $expect = expectCats();

    /**
     * All is representative of what's in the pics directory
     */
    $actual = catSamplez()->all();
    expect($actual)->toBe($expect);

    /**
     * Pool is not the same as all as it's shuffled
     */
    expect(catSamplez()->pool())->toHaveCount(count($actual))->not->toBe($actual);

    /**
     * The pool contains the same images just in wrong order
     */
    $poolSorted = collect(catSamplez()->pool())->sort()->values()->all();
    expect($poolSorted)->toBe($expect);

    $random = [];
    while (count($random) < count($actual)) {
        $random[] = catSamplez()->path();
    }
    expect($random)->not->toBe($expect);
    $randomSorted = collect($random)->sort()->values()->all();
    expect($randomSorted)->toBe($expect);

    expect(catSamplez()->pool())->toBe([]);

    $temp = catSamplez()->path();

    /**
     * Auto refeed
     */
    expect(catSamplez()->pool())->toHaveCount(count($expect) - 1);

    $random2 = [$temp];
    while (count($random2) < count($actual)) {
        $random2[] = catSamplez()->path();
    }
    expect($random2)->not->toBe($expect);
    $random2Sorted = collect($random2)->sort()->values()->all();
    expect($random2Sorted)->toBe($expect);
});
