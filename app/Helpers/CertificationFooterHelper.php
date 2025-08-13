<?php

use App\Models\CertificationFooter;

if (!function_exists('getCertificationFooter')) {
    function getCertificationFooter()
    {
        return CertificationFooter::first();
    }
}