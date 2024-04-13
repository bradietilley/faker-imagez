<?php

namespace BradieTilley\FakerImagez;

class CombineImagez extends Imagez
{
    public function __construct(array $all)
    {
        $this->replaceAll($all);
    }

    /**
     * Combine multiple imagez generators into a single one.
     */
    public static function make(Imagez ...$imagez): static
    {
        $all = [];

        foreach ($imagez as $generator) {
            $all = array_merge($all, $generator->all());
        }

        return new static($all);
    }

    /**
     * This isn't needed as the "all" image collection is pre-defined upon creation.
     */
    public static function basePath(): string
    {
        return '/dev/null';
    }
}