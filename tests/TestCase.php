<?php namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\DatabaseSetup;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseSetup;

    public function setUp(): void
    {
        parent::setUp();
        $this->setupDatabase();
    }

    public function assertDatabaseHasMany(array $expected = [])
    {
        collect($expected)->each(function($data, $table) {
            $this->assertDatabaseHas($table, $data);
        });
    }
}
