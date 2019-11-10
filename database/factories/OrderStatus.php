<?php

use App\Models\OrderStatus;

$factory->define(OrderStatus::class, function (Faker\Generator $faker) {
    $selection = ['Completed', 'Refunded', 'Partially Refunded', 'Cancelled', 'Awaiting Payment'];

    return [
        'name' => $faker->randomElement($selection),
    ];
});
