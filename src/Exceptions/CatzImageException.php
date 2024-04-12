<?php

namespace BradieTilley\Catz\Exceptions;

use Exception;

final class CatzImageException extends Exception
{
    public static function make(string $message): static
    {
        return new static($message);
    }
}
