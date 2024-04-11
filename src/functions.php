<?php

use BradieTilley\Catz\Catz;

if (!function_exists('catz')) {
    function catz(): Catz
    {
        return Catz::instance();
    }
}
