<?php

use App\Models\TicketStatus;

$factory->define(TicketStatus::class, function (Faker\Generator $faker) {
    $selection = ['Sold Out', 'Sales Have Ended', 'Not On Sale Yet', 'On Sale'];

    return [
        'name' => $faker->randomElement($selection),
    ];
});
