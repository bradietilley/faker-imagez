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
    expect($generator)->all()->toBe(array_merge(expectCats(), expectDogs(), expectFood()));
});
