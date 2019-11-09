<?php namespace Tests\Features;

use Tests\TestCase;
use Log;

class FeatureDemoTest extends TestCase
{

    /**
     * @test
     */
    public function it_tests_the_framework_is_setup()
    {
        Log::debug("This is a debug entry");
        Log::info("This is an info entry");
        $this->assertTrue(true);
    }
}
