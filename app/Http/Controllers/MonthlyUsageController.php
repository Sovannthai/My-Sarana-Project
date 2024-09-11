<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MonthlyUsageResource;
use App\Repositories\MonthlyUsageRepository;
use App\Http\Requests\StoreMonthlyUsageRequest;
use App\Http\Requests\UpdateMonthlyUsageRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MonthlyUsageController extends Controller
{
    protected $MonthlyUsageRepository;

    /**
     * MonthlyUsageController constructor.
     *
     * @param MonthlyUsageRepository $MonthlyUsageRepository
     */
    public function __construct(MonthlyUsageRepository $MonthlyUsageRepository)
    {
        $this->MonthlyUsageRepository = $MonthlyUsageRepository;
    }

    /**
     * Display a listing of the room pricings.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $MonthlyUsages = $this->MonthlyUsageRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => MonthlyUsageResource::collection($MonthlyUsages)
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
            $MonthlyUsage = $this->MonthlyUsageRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($MonthlyUsage)
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
     * @param StoreMonthlyUsageRequest $request
     * @return JsonResponse
     */
    public function store(StoreMonthlyUsageRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $MonthlyUsage = $this->MonthlyUsageRepository->create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($MonthlyUsage)
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
     * @param UpdateMonthlyUsageRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateMonthlyUsageRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $MonthlyUsage = $this->MonthlyUsageRepository->update($id, $validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($MonthlyUsage)
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
            $this->MonthlyUsageRepository->delete($id);
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
            $this->MonthlyUsageRepository->forceDelete($id);
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
