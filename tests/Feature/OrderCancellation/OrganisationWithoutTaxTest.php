<?php namespace Tests\Features;

use Tests\Concerns\OrganisationWithoutTax;
use Tests\TestCase;

class OrganisationWithoutTaxTest extends TestCase
{
    use OrganisationWithoutTax;

    public function setUp(): void
    {
        parent::setUp();
        $this->setupOrganisationWithoutTax();
    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_single_ticket()
    {

    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_multiple_tickets()
    {

    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_single_ticket_with_percentage_booking_fees()
    {

    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_multiple_tickets_with_percentage_booking_fees()
    {

    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_single_ticket_with_fixed_booking_fees()
    {

    }

    /**
     * @test
     */
    public function it_cancels_and_refunds_order_with_multiple_tickets_with_fixed_booking_fees()
    {

    }
}
