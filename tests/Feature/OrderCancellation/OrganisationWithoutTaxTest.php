<?php namespace Tests\Features;

use Tests\Concerns\OrganisationWithoutTax;
use Tests\TestCase;

class OrganisationWithoutTaxTest extends TestCase
{
    use OrganisationWithoutTax;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\FirstRunMiddleware::class,
        ]);
        $this->setupOrganisationWithoutTax();
    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_single_ticket()
    {
        // Setup single attendee order
        list($order, $attendees) = $this->setupSingleTicketOrder();
        $response = $this->actingAs($this->getAccountUser())
            ->post("event/order/$order->id/cancel", [
                'attendees' => $attendees,
            ]);

        // Check refund call works
        $response->assertStatus(200);
        // Assert database is correct after refund and cancel
        $this->assertDatabaseHasMany($this->singleTicketOrderAfterRefund());
    }

    /**
     * @test
     */
    // public function it_cancels_and_refunds_order_with_multiple_tickets()
    // {

    // }

    // /**
    //  * @test
    //  */
    // public function it_cancels_and_refunds_order_with_single_ticket_with_percentage_booking_fees()
    // {

    // }

    // /**
    //  * @test
    //  */
    // public function it_cancels_and_refunds_order_with_multiple_tickets_with_percentage_booking_fees()
    // {

    // }

    // /**
    //  * @test
    //  */
    // public function it_cancels_and_refunds_order_with_single_ticket_with_fixed_booking_fees()
    // {

    // }

    // /**
    //  * @test
    //  */
    // public function it_cancels_and_refunds_order_with_multiple_tickets_with_fixed_booking_fees()
    // {

    // }

    /**
     * The expected database state after a single attendee order cancellation.
     */
    private function singleTicketOrderAfterRefund()
    {
        return [
            'event_stats' => [
                'tickets_sold' => 0,
                'sales_volume' => 0.00,
                'organiser_fees_volume' => 0.00,
            ],
            'tickets' => [
                'sales_volume' => 0.00,
                'organiser_fees_volume' => 0.00,
                'quantity_sold' => 0,
                'quantity_available' => 50,
            ],
            'orders' => [
                'organiser_booking_fee' => 0.00,
                'amount_refunded' => 100.00,
                'is_refunded' => true,
            ],
            'attendees' => [
                'is_refunded' => true,
                'is_cancelled' => true,
            ],
        ];
    }
}
