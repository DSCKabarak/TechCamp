<?php

use Illuminate\Support\Carbon;

$factory->define(App\Models\EventStats::class, function (Faker\Generator $faker) {
    return [
        'date' => Carbon::now(),
        'views' => 0,
        'unique_views' => 0,
        'tickets_sold' => 0,
        'sales_volume' => 0,
        'organiser_fees_volume' => 0,
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
    ];
});
