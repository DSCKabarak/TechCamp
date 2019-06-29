<?php

$factory->define(App\Models\Timezone::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->timezone,
        'location' => $faker->city,
    ];
});