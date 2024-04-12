<?php

namespace BradieTilley\FakerCatz\Exceptions;

use Exception;

final class CatzImageException extends Exception
{
    public static function make(string $message): static
    {
        return new static($message);
    }
}
