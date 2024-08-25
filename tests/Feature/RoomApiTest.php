<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Room;

class RoomApiTest extends TestCase
{
    use RefreshDatabase;

    public function it_can_list_all_rooms()
    {
        $response = $this->getJson('/api/v1/rooms');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         '*' => [
                             'id',
                             'room_number',
                             'description',
                             'size',
                             'floor',
                             'status',
                             'created_at',
                             'updated_at',
                         ],
                     ],
                 ]);
    }

    public function it_can_create_a_room()
    {
        $response = $this->postJson('/api/v1/rooms', [
            'room_number' => '101',
            'description' => 'A nice room',
            'size' => 'Large',
            'floor' => 1,
            'status' => 'available',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'room_number' => '101',
                         'description' => 'A nice room',
                         'size' => 'Large',
                         'floor' => 1,
                         'status' => 'available',
                     ],
                 ]);
    }

    public function it_can_update_a_room()
    {
        $room = Room::factory()->create();

        $updatedData = [
            'room_number' => '102',
            'description' => 'Updated description',
            'size' => 'Medium',
            'floor' => 2,
            'status' => 'occupied',
        ];

        $response = $this->patchJson("/api/v1/rooms/{$room->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => array_merge($room->toArray(), $updatedData),
                 ]);
    }

    public function it_can_delete_a_room()
    {
        $room = Room::factory()->create();

        $response = $this->deleteJson("/api/v1/rooms/{$room->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'status' => 'success',
                    'message' => 'Room deleted successfully'
                 ]);

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
}
