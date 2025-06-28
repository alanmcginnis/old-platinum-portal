<?php

namespace Tests\Feature;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function vendor_index_displays_vendors()
    {
        // Arrange: create some vendors
        $vendors = Vendor::factory()->count(3)->create();

        // Act: visit the index route
        $response = $this->actingAs(User::factory()->create())
                         ->get('/vendors');

        // Assert: we see the first vendor name
        $response->assertStatus(200)
                 ->assertSee($vendors->first()->name);
    }
}