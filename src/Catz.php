<?php

namespace BradieTilley\FakerCatz;

use BradieTilley\FakerImagez\Imagez;

class Catz extends Imagez
{
    public static function basePath(): string
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'images';
    }
}
