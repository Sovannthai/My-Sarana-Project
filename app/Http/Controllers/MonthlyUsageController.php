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
    protected $monthlyUsageRepository;

    /**
     * MonthlyUsageController constructor.
     *
     * @param MonthlyUsageRepository $monthlyUsageRepository
     */
    public function __construct(MonthlyUsageRepository $monthlyUsageRepository)
    {
        $this->monthlyUsageRepository = $monthlyUsageRepository;
    }

    /**
     * Display a listing of the monthly usage.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $monthlyUsages = $this->monthlyUsageRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => MonthlyUsageResource::collection($monthlyUsages)
        ]);
    }

    /**
     * Display the specified monthly usage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $monthlyUsage = $this->monthlyUsageRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($monthlyUsage)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Monthly usage not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Store a newly created monthly usage in storage.
     *
     * @param StoreMonthlyUsageRequest $request
     * @return JsonResponse
     */
    public function store(StoreMonthlyUsageRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $monthlyUsage = $this->monthlyUsageRepository->create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($monthlyUsage)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create monthly usage',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified monthly usage in storage.
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
            $monthlyUsage = $this->monthlyUsageRepository->update($id, $validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new MonthlyUsageResource($monthlyUsage)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update monthly usage',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified monthly usage from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->monthlyUsageRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Monthly usage deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Monthly usage not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Permanently remove the specified monthly usage from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->monthlyUsageRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Monthly usage permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Monthly usage not found'
            ], 404); // 404 Not Found
        }
    }
}
