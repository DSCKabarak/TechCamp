<?php

use Illuminate\Support\Carbon;

$factory->define(App\Models\EventAccessCodes::class, function (Faker\Generator $faker) {
    return [
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
        'code' => $faker->word,
        'usage_count' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'deleted_at' => null,
    ];
});
