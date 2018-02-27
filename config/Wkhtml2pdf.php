<?php

return [

    'debug'       => env('APP_DEBUG_PDF', true),
    'binpath'     => '/wkhtmltopdf/bin/',
    'binfile'     => 'wkhtmltopdf.exe',
    'output_mode' => 'F',
    'tmppath' => '/tmp/',
];
