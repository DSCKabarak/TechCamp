<?php

use Carbon\Carbon;

$factory->define(App\Models\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text,
    ];
});

$factory->define(App\Models\TicketStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text,
    ];
});

$factory->define(App\Models\ReservedTickets::class, function (Faker\Generator $faker) {
    return [
        'ticket_id' => function () {
            return factory(App\Models\Ticket::class)->create()->id;
        },
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
        'quantity_reserved' => 50,
        'expires' => Carbon::now()->addDays(2),
        'session_id' => $faker->randomNumber
    ];
});

$factory->define(App\Models\EventStats::class, function (Faker\Generator $faker) {
    return [
        'date' => Carbon::now(),
        'views' => 0,
        'unique_views' => 0,
        'tickets_sold' => 0,
        'sales_volumne' => 0,
        'organiser_fees_volume' => 0,
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
    ];
});

$factory->define(App\Models\Message::class, function (Faker\Generator $faker) {
    return [
        'message' => $faker->text,
        'subject' => $faker->text,
        'recipients' => 0,
    ];
});

$factory->define(App\Models\EventImage::class, function (Faker\Generator $faker) {
    return [
        'image_path' => $faker->imageUrl(),
        'event_id' => function () {
            return factory(App\Models\Event::class)->create()->id;
        },
        'account_id' => function () {
            return factory(App\Models\Account::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});
