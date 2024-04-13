<?php


test('you can combine multiple imagez generators', function () {
    $generator = catSamplez()->combine(dogSamplez());

    expect($generator)->all()->toBe(array_merge(expectCats(), expectDogs()));
});
