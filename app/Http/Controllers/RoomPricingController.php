<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoomPricingResource;
use App\Repositories\RoomPricingRepository;
use App\Http\Requests\StoreRoomPricingRequest;
use App\Http\Requests\UpdateRoomPricingRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomPricingController extends Controller
{
    protected $roomPricingRepository;

    /**
     * RoomPricingController constructor.
     *
     * @param RoomPricingRepository $roomPricingRepository
     */
    public function __construct(RoomPricingRepository $roomPricingRepository)
    {
        $this->roomPricingRepository = $roomPricingRepository;
    }

    /**
     * Display a listing of the room pricings.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roomPricings = $this->roomPricingRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => RoomPricingResource::collection($roomPricings)
        ]);
    }

    /**
     * Display the specified room pricing.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $roomPricing = $this->roomPricingRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new RoomPricingResource($roomPricing)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room pricing not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Store a newly created room pricing in storage.
     *
     * @param StoreRoomPricingRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoomPricingRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $roomPricing = $this->roomPricingRepository->create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new RoomPricingResource($roomPricing)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create room pricing',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified room pricing in storage.
     *
     * @param UpdateRoomPricingRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRoomPricingRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $roomPricing = $this->roomPricingRepository->update($id, $validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new RoomPricingResource($roomPricing)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update room pricing',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified room pricing from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->roomPricingRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Room pricing deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room pricing not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Permanently remove the specified room pricing from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->roomPricingRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Room pricing permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room pricing not found'
            ], 404); // 404 Not Found
        }
    }
}
