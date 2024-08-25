<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Room;

class RoomApiValidationTest extends TestCase
{
    use RefreshDatabase;

    public function it_requires_room_number()
    {
        $response = $this->postJson('/api/v1/rooms', [
            'description' => 'A nice room',
            'size' => 'Large',
            'floor' => 1,
            'status' => 'available',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('room_number');
    }

    public function it_requires_valid_room_number()
    {
        $response = $this->postJson('/api/v1/rooms', [
            'room_number' => '',
            'description' => 'A nice room',
            'size' => 'Large',
            'floor' => 1,
            'status' => 'available',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('room_number');
    }

    public function it_requires_valid_floor()
    {
        $response = $this->postJson('/api/v1/rooms', [
            'room_number' => '101',
            'description' => 'A nice room',
            'size' => 'Large',
            'floor' => 'invalid',
            'status' => 'available',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('floor');
    }

    public function it_requires_valid_status()
    {
        $response = $this->postJson('/api/v1/rooms', [
            'room_number' => '101',
            'description' => 'A nice room',
            'size' => 'Large',
            'floor' => 1,
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('status');
    }
}
