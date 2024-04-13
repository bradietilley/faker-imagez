<?php

use Illuminate\Support\Collection;
use Tests\Fixtures\CatSampleImagez;
use Tests\Fixtures\DogSampleImagez;
use Tests\Fixtures\FoodSampleImagez;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

if (!function_exists('catSamplez')) {
    function catSamplez(): CatSampleImagez
    {
        return CatSampleImagez::instance();
    }
}

if (!function_exists('dogSamplez')) {
    function dogSamplez(): DogSampleImagez
    {
        return DogSampleImagez::instance();
    }
}

if (!function_exists('foodSamplez')) {
    function foodSamplez(): FoodSampleImagez
    {
        return FoodSampleImagez::instance();
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

function expectFood(): array
{
    $min = 1;
    $max = 9;

    $expect = Collection::range($min, $max)
        ->map(fn (int $i) => 'food_'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg')
        ->map(fn (string $name) => FoodSampleImagez::absolutePath($name))
        ->values()
        ->all();

    return $expect;
}
