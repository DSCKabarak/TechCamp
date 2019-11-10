<?php namespace Tests\Concerns;

use App\Models\Event;
use App\Models\Account;
use App\Models\AccountPaymentGateway;
use App\Models\Country;
use App\Models\Currency;
use App\Models\OrderStatus;
use App\Models\Organiser;
use App\Models\PaymentGateway;
use App\Models\TicketStatus;
use App\Models\Timezone;
use App\Models\User;

trait OrganisationWithoutTax
{
    public function setupOrganisationWithoutTax()
    {
        $orderStatuses = collect([
            ['name' => 'Completed'],
            ['name' => 'Refunded'],
            ['name' => 'Partially Refunded'],
            ['name' => 'Cancelled'],
            ['name' => 'Awaiting Payment'],
        ]);
        $orderStatuses->map(function($orderStatus) {
            factory(OrderStatus::class)->create($orderStatus);
        });

        $ticketStatuses = collect([
            ['name' => 'Sold Out'],
            ['name' => 'Sales Have Ended'],
            ['name' => 'Not On Sale Yet'],
            ['name' => 'On Sale'],
        ]);
        $ticketStatuses->map(function($ticketStatus) {
            factory(TicketStatus::class)->create($ticketStatus);
        });

        $country = factory(Country::class)->states('United Kingdom')->create();
        $currency = factory(Currency::class)->states('GBP')->create();
        $timezone = factory(Timezone::class)->states('Europe/London')->create();
        $paymentGateway = factory(PaymentGateway::class)->states('Dummy')->create();

        // Setup base account information with correct country, currency and timezones
        $account = factory(Account::class)->create([
            'name' => 'Local Integration Test Account',
            'timezone_id' => $timezone->id, // London
            'currency_id' => $currency->id, // Pound
            'country_id' => $country->id, // UK
        ]);

        factory(AccountPaymentGateway::class)->create([
            'account_id' => $account->id,
            'payment_gateway_id' => $paymentGateway->id,
        ]);


        $user = factory(User::class)->create([
            'account_id' => $account->id,
            'email' => 'local@test.com',
            'password' => \Hash::make('pass'),
            'is_parent' => true, // Top level user
            'is_registered' => true,
            'is_confirmed' => true,
        ]);

        $organiserNoTax = factory(Organiser::class)->create([
            'account_id' => $account->id,
            'name' => 'Test Organiser (No Tax)',
            'charge_tax' => false,
            'tax_name' => '',
            'tax_value' => 0.00
        ]);

        $event = factory(Event::class)->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'organiser_id' => $organiserNoTax->id,
            'title' => 'Event without Fees',
            'currency_id' => $currency->id, // Pound
            'is_live' => true,
        ]);

        $eventWithPercentageFees = factory(Event::class)->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'organiser_id' => $organiserNoTax->id,
            'title' => 'Event with Percentage Fees',
            'organiser_fee_percentage' => 5.0,
            'currency_id' => $currency->id, // Pound
            'is_live' => true,
        ]);

        $eventWithFixedFees = factory(Event::class)->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'organiser_id' => $organiserNoTax->id,
            'title' => 'Event with Fixed Fees',
            'organiser_fee_fixed' => 2.50,
            'currency_id' => $currency->id, // Pound
            'is_live' => true,
        ]);
    }
}