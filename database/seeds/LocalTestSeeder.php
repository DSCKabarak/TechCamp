<?php

use App\Models\Account;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventAccessCodes;
use App\Models\EventStats;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Organiser;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LocalTestSeeder extends Seeder
{
    /**
     * Run the seeds to allow for local database test cases.
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        // Setup Test account
        $this->out("<info>Setting up basic settings</info>");
        $this->out("<info>Seeding account</info>");
        $account = factory(Account::class)->create([
            'name' => 'Local Integration Test Account',
            'timezone_id' => 38, // Brussels
            'currency_id' => 2, // Euro
        ]);

        // Setup test user with login details
        $this->out("<info>Seeding User</info>");
        $user = factory(User::class)->create([
            'account_id' => $account->id,
            'email' => 'local@test.com',
            'password' => Hash::make('pass'),
            'is_parent' => true, // Top level user
            'is_registered' => true,
            'is_confirmed' => true,
        ]);

        // Organiser with no tax (organisers)
        $this->out("<info>Seeding Organiser (no tax)</info>");
        $organiserNoTax = factory(Organiser::class)->create([
            'account_id' => $account->id,
            'name' => 'Test Organiser (No Tax)',
            'charge_tax' => false,
            'tax_name' => '',
            'tax_value' => 0.00
        ]);

        // Event (events)
        $this->out("<info>Seeding event</info>");
        $event = factory(Event::class)->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'organiser_id' => $organiserNoTax->id,
            'title' => 'Local Orchid Show',
            'is_live' => true,
        ]);

        // Setup event access codes to allow testing hidden code functionality on the tickets public page
        $this->out("<info>Seeding event access code</info>");
        $eventAccessCode = factory(EventAccessCodes::class)->create([
            'event_id' => $event->id,
            'code' => 'SHOWME',
        ]);

        // Setup two tickets, one visible and one hidden
        $this->out("<info>Seeding visible ticket</info>");
        $visibleTicket = factory(Ticket::class)->create([
            'user_id' => $user->id,
            'edited_by_user_id' => $user->id,
            'account_id' => $account->id,
            'order_id' => null, // We'll create the orders on these later
            'event_id' => $event->id,
            'title' => 'Visible Ticket',
            'price' => 100.00,
            'is_hidden' => false,
        ]);

        $this->out("<info>Seeding hidden ticket</info>");
        $hiddenTicket = factory(Ticket::class)->create([
            'user_id' => $user->id,
            'edited_by_user_id' => $user->id,
            'account_id' => $account->id,
            'order_id' => null, // We'll create the orders on these later
            'event_id' => $event->id,
            'title' => 'Hidden Ticket',
            'price' => 100.00,
            'is_hidden' => true,
        ]);

        // Attach unlock code to hidden ticket
        $this->out("<info>Attaching access code to hidden ticket</info>");
        $hiddenTicket->event_access_codes()->attach($eventAccessCode);

        // Event Stats
        $this->out("<info>Seeding Event Stats</info>");
        $eventStats = factory(EventStats::class)->create([
            'date' => Carbon::now()->format('Y-m-d'),
            'views' => 0,
            'unique_views' => 0,
            'tickets_sold' => 6,
            'sales_volume' => 600.00,
            'event_id' => $event->id,
        ]);

        // Orders (order_items, ticket_order) as normie
        $this->out("<info>Seeding single attendee order</info>");
        $singleAttendeeOrder = factory(Order::class)->create([
            'account_id' => $account->id,
            'order_status_id' => 1, // Completed Order
            'discount' => 0.00,
            'booking_fee' => 0.00,
            'organiser_booking_fee' => 0.00,
            'amount' => 100.00,
            'event_id' => $event->id,
            'is_payment_received' => true,
        ]);

        $visibleTicket->order_id = $singleAttendeeOrder->id;
        $visibleTicket->quantity_sold = 1;
        $visibleTicket->sales_volume = 100.00;
        $visibleTicket->save();

        $this->out("<info>Attaching visible ticket to single attendee order</info>");
        $singleAttendeeOrder->tickets()->attach($visibleTicket);

        $this->out("<info>Seeding single attendee order item/info>");
        $singleAttendeeOrderItem = factory(OrderItem::class)->create([
            'title' => $visibleTicket->title,
            'quantity' => 1,
            'unit_price' => 100.00,
            'unit_booking_fee' => 0.00,
            'order_id' => $singleAttendeeOrder->id,
        ]);

        $this->out("<info>Seeding single attendee</info>");
        $singleAttendee = factory(Attendee::class)->create([
            'order_id' => $singleAttendeeOrder->id,
            'event_id' => $event->id,
            'ticket_id' => $visibleTicket->id,
            'account_id' => $account->id,
        ]);

        $this->out("<info>Seeding multiple attendees order</info>");
        $multipleAttendeeOrder = factory(Order::class)->create([
            'account_id' => $account->id,
            'order_status_id' => 1, // Completed Order
            'discount' => 0.00,
            'booking_fee' => 0.00,
            'organiser_booking_fee' => 0.00,
            'amount' => 500.00,
            'event_id' => $event->id,
            'is_payment_received' => true,
        ]);

        $hiddenTicket->order_id = $multipleAttendeeOrder->id;
        $hiddenTicket->quantity_sold = 5;
        $hiddenTicket->sales_volume = 500.00;
        $hiddenTicket->save();

        $this->out("<info>Attaching hidden ticket to multiple attendees order</info>");
        $multipleAttendeeOrder->tickets()->attach($hiddenTicket);

        $this->out("<info>Seeding multiple attendees order item/info>");
        $multipleAttendeesOrderItem = factory(OrderItem::class)->create([
            'title' => $visibleTicket->title,
            'quantity' => 5,
            'unit_price' => 100.00,
            'unit_booking_fee' => 0.00,
            'order_id' => $multipleAttendeeOrder->id,
        ]);

        $this->out("<info>Seeding multiple attendees</info>");
        $multipleAttendees = factory(Attendee::class, 5)->create([
            'order_id' => $multipleAttendeeOrder->id,
            'event_id' => $event->id,
            'ticket_id' => $hiddenTicket->id,
            'account_id' => $account->id,
        ]);

        // TODO Event Stats (event_stats) to match revenues


        // Organiser with With tax (organisers)
//        $organiserWithTax = factory(Organiser::class)->create([
//            'account_id' => $account->id,
//            'name' => 'Test Organiser (With Tax)',
//            'charge_tax' => false,
//            'tax_name' => '',
//            'tax_value' => 0.00
//        ]);
        // Organiser tax (organisers)
            // Event (events)
            // Tickets (tickets)
                // One visible
                // One Hidden
            // Orders (order_items, ticket_order)
                // Single attendee (attendees)
                // Mulitple attendees (attendees)

        $this->command->alert(
            sprintf("Local Test Seed Finished"
                . "\n\nYou can log in with the Test User using"
                . "\n\nu: %s\np: %s\n\n", $user->email, 'pass')
        );
    }

    /**
     * @param string $message
     */
    protected function out($message)
    {
        $this->command->getOutput()->writeln($message);
    }
}