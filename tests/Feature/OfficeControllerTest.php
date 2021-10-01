<?php

namespace Tests\Feature;

use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Office::factory()->count(3)->create();

        $response = $this->get('/api/offices');

        dd(
            $response->json()
        );

        $response->assertOk()->dump();
    }
}
