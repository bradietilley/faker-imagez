<?php

use Tests\Fixtures\Examplez;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

if (!function_exists('examplez')) {
    function examplez(): Examplez
    {
        return Examplez::instance();
    }
}
