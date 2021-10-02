<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Tag;
use App\Models\User;
use GuzzleHttp\Promise\Create;
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
    // public function testitListsAllOfficesInPaginatedWay()
    // {
    //     // Office::factory()->count(3)->create();

    //     $response = $this->get('/api/offices');
        
    //     $response->assertOk()->dump();
    // }


     /**
     * A basic feature test.
     *
     * @test
     */

    // public function OnlyListsOfficesThatAreNotHiddenAndApproved()
    // {
    //     Office::factory(3)->create();

    //     Office::factory(3)->create(['hidden' => true]);
    //     Office::factory(3)->create(['approval_status' => Office::APPROVAL_PENDING]);

    //     $response = $this->get('/api/offices');
        
    //     $response->assertOk()->dump();
    // }

     /**
     * A basic feature test.
     *
     * @test
     */

    // public function ItFiltersByHostId()
    // {
    //     Office::factory(3)->create();

    //     $host = User::factory()->create();

    //     $office = Office::factory()->for($host)->create();

    //     $response = $this->get(
    //         '/api/offices?host_id='.$host->id
    //     );

    //     $response->assertOk();
    //     $response->assertJsonCount(1, 'data');
    // }


     /**
     * A basic feature test.
     *
     * @test
     */
    // public function ItFiltersByUserId()
    // {
    //     Office::factory(3)->create();

    //     $user = User::factory()->create();

    //     $office = Office::factory()->create();

    //     Reservation::factory()->for(Office::factory())->create();
    //     Reservation::factory()->for($office)->for($user)->create();
        
    //     $response = $this->get(
    //         '/api/offices?user_id='.$user->id
    //     );
        
    //     $response->assertOk(200);
    //     $response->assertJsonCount(1, 'data');
    // }


    /**
     * A basic feature test.
     *
     * @test
     */

    public function ItIncludesTagsImagesAndUers()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $office = Office::factory()->for($user)->create();

        $office->tags()->attach($tag);
        $office->images()->create(['path' => 'image.jpg']);

        $response = $this->get('/api/offices');
        
        $response->assertOk();

        $this->assertIsArray($response->json('data')[0]['tags']);
        $this->assertCount(1, $response->json('data')[0]['tags']);
        $this->assertIsArray($response->json('data')[0]['images']);
        $this->assertCount(1, $response->json('data')[0]['images']);
        $this->assertEquals($user->id, $response->json('data')[0]['user']['id']);

    }

    /**
     * A basic feature test.
     *
     * @test
     */

    public function itReturnsTheNumberOfActiveReservations()
    {
        $office = Office::factory()->create();

        Reservation::factory()->for($office)->create(['status' => Reservation::STATUS_ACTIVE]);
        Reservation::factory()->for($office)->create(['status' => Reservation::STATUS_CANCELLED]);

        $response = $this->get('/api/offices');
        
        $response->assertOk();

        // $response->dump();

        $this->assertEquals(1, $response->json('data')[0]['reservations_count']);
    }

    /**
     * @test
     */

    public function itOrdersByDistanceWhenCoordinatesAreProvided()
    {
        // 38.720661384644846
        // -9.16044783453807
        
        $office1 = Office::factory()->create([
            'lat' => '39.74051727562952',
            'lng' => '-8.770375324893696',
            'title' => 'Leiria'
        ]);

        $office2 = Office::factory()->create([
            'lat' => '39.07753883078113',
            'lng' => '-9.281266331143293',
            'title' => 'Torres Vedras'
        ]);

        // $response = $this->get('/api/offices?lat=38.720661384644846&lng=-9.16044783453807');

        // $response->assertOk();
        // // $response->dump();
        // $this->assertEquals('Torres Vedras', $response->json('data')[0]['title']);
        // $this->assertEquals('Leiria', $response->json('data')[1]['title']); 


        $response = $this->get('/api/offices');
        $response->assertOk();
        $this->assertEquals('Leiria', $response->json('data')[0]['title']);
        $this->assertEquals('Torres Vedras', $response->json('data')[1]['title']); 
    }
}
