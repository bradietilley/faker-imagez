<?php

use Illuminate\Support\Collection;
use Tests\Fixtures\CatSampleImagez;
use Tests\Fixtures\DogSampleImagez;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

if (!function_exists('examplez')) {
    function catSamplez(): CatSampleImagez
    {
        return CatSampleImagez::instance();
    }
}

if (!function_exists('examplez2')) {
    function dogSamplez(): DogSampleImagez
    {
        return DogSampleImagez::instance();
    }
}

function expectCats(): array
{
    $min = 1;
    $max = 9;

    $expect = Collection::range($min, $max)
        ->map(fn (int $i) => 'cat_'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg')
        ->map(fn (string $name) => CatSampleImagez::absolutePath($name))
        ->values()
        ->all();

    return $expect;
}

function expectDogs(): array
{
    $min = 1;
    $max = 9;

    $expect = Collection::range($min, $max)
        ->map(fn (int $i) => 'dog_'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg')
        ->map(fn (string $name) => DogSampleImagez::absolutePath($name))
        ->values()
        ->all();

    return $expect;
}
