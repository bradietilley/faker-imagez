<?php

namespace BradieTilley\FakerImagez\Exceptions;

use Exception;

final class ImagezException extends Exception
{
    public static function make(string $message): static
    {
        return new static($message);
    }
}
