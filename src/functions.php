<?php

use BradieTilley\FakerCatz\Catz;

if (!function_exists('catz')) {
    function catz(): Catz
    {
        return Catz::instance();
    }
}
