<?php

use Illuminate\Support\Carbon;

$factory->define(App\Models\Ticket::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'edited_by_user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'account_id' => function () {
            return factory(App\Models\Account::class)->create()->id;
        },
        'order_id' => function () {
            return factory(App\Models\Order::class)->create()->id;
        },
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
        'title' => $faker->name,
        'description' => $faker->text,
        'price' => 50.00,
        'max_per_person' => 4,
        'min_per_person' => 1,
        'quantity_available' => 50,
        'quantity_sold' => 0,
        'start_sale_date' => Carbon::now()->format(config('attendize.default_datetime_format')),
        'end_sale_date' => Carbon::now()->addDays(20)->format(config('attendize.default_datetime_format')),
        'sales_volume' => 0,
        'organiser_fees_volume' => 0,
        'is_paused' => 0,
        'public_id' => null,
        'sort_order' => 0,
        'is_hidden' => false,
    ];
});
