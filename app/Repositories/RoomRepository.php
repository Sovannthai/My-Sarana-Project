<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository
{
    /**
     * Get all rooms.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Room::all();
    }

    /**
     * Get a room by ID.
     *
     * @param int $id
     * @return Room
     */
    public function findById(int $id): Room
    {
        return Room::findOrFail($id);
    }

    /**
     * Create a new room.
     *
     * @param array $data
     * @return Room
     */
    public function create(array $data): Room
    {
        return Room::create($data);
    }

    /**
     * Update an existing room.
     *
     * @param int $id
     * @param array $data
     * @return Room
     */
    public function update(int $id, array $data): Room
    {
        $room = $this->findById($id);
        $room->update($data);
        return $room;
    }

    /**
     * Soft delete a room by ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $room = $this->findById($id);
        $room->delete();
    }

    /**
     * Permanently delete a room by ID.
     *
     * @param int $id
     * @return void
     */
    public function forceDelete(int $id): void
    {
        $room = $this->findById($id);
        $room->forceDelete();
    }
}
