<?php

use BradieTilley\FakerImagez\CombineImagez;

test('you can combine multiple imagez generators', function () {
    /**
     * Combine two
     */
    $generator = catSamplez()->combine(dogSamplez());
    expect($generator)->all()->toBe(array_merge(expectCats(), expectDogs()));

    /**
     * Combine three
     */
    $generator = catSamplez()->combine(dogSamplez(), foodSamplez());
    expect($generator)->all()->toBe(array_merge(expectCats(), expectDogs(), expectFood()));

    /**
     * Combine using CombineImagez
     */
    $generator = CombineImagez::make(catSamplez(), dogSamplez(), foodSamplez());
    expect($generator)->all()->toBe($expectAll = array_merge(expectCats(), expectDogs(), expectFood()));

    /**
     * Can fetch all paths from all 3 sources but in a random order
     */
    $all = [];

    while (count($all) < count($expectAll)) {
        $all[] = $generator->path();
    }

    expect($all)->not->toBe($expectAll);

    $actual = collect($all)->sort()->values()->all();
    $expect = collect($expectAll)->sort()->values()->all();

    expect($actual)->toBe($expect);
});
