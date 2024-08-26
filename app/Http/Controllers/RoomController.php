<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoomResource;
use App\Repositories\RoomRepository;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomController extends Controller
{
    protected $roomRepository;

    /**
     * RoomController constructor.
     *
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * Display a listing of the rooms.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $rooms = $this->roomRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => RoomResource::collection($rooms)
        ]);
    }

    /**
     * Display the specified room.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $room = $this->roomRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new RoomResource($room)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404); // 404 Not Found
        }
    }

    public function store(StoreRoomRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $room = $this->roomRepository->create($validated);

            // Attach amenities if provided
            if (isset($validated['amenities'])) {
                $room->amenities()->attach($validated['amenities']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new RoomResource($room)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create room',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateRoomRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $room = $this->roomRepository->update($id, $validated);

            // Update amenities if provided
            if (isset($validated['amenities'])) {
                $room->amenities()->sync($validated['amenities']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new RoomResource($room)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update room',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified room from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->roomRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Room deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Permanently remove the specified room from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->roomRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Room permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404); // 404 Not Found
        }
    }
}
