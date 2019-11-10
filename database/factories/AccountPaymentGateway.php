<?php

use App\Models\AccountPaymentGateway;

$factory->define(AccountPaymentGateway::class, function (Faker\Generator $faker) {
    return [
        'account_id' => function () {
            return factory(App\Models\Account::class)->create()->id;
        },
        'payment_gateway_id' => function () {
            return factory(App\Models\PaymentGateway::class)->create()->id;
        },
        'config' => [
            'apiKey' => '',
            'publishableKey' => '',
        ],
    ];
});
