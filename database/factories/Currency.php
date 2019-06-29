<?php

$factory->define(App\Models\Currency::class, function (Faker\Generator $faker) {
    return [
        'title' => "Dollar",
        'symbol_left' => "$",
        'symbol_right' => "",
        'code' => 'USD',
        'decimal_place' => 2,
        'value' => 100.00,
        'decimal_point' => '.',
        'thousand_point' => ',',
        'status' => 1,
    ];
});