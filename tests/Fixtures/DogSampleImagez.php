<?php

namespace Tests\Fixtures;

use BradieTilley\FakerImagez\Imagez;

class DogSampleImagez extends Imagez
{
    public static function basePath(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'dogs';
    }
}
