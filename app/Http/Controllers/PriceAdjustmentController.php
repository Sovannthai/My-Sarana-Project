<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PriceAdjustmentResource;
use App\Repositories\PriceAdjustmentRepository;
use App\Http\Requests\StorePriceAdjustmentRequest;
use App\Http\Requests\UpdatePriceAdjustmentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PriceAdjustmentController extends Controller
{
    protected $PriceAdjustmentRepository;

    /**
     * PriceAdjustmentController constructor.
     *
     * @param PriceAdjustmentRepository $PriceAdjustmentRepository
     */
    public function __construct(PriceAdjustmentRepository $PriceAdjustmentRepository)
    {
        $this->PriceAdjustmentRepository = $PriceAdjustmentRepository;
    }

    /**
     * Display a listing of the room pricings.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $PriceAdjustments = $this->PriceAdjustmentRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => PriceAdjustmentResource::collection($PriceAdjustments)
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
            $PriceAdjustment = $this->PriceAdjustmentRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new PriceAdjustmentResource($PriceAdjustment)
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
     * @param StorePriceAdjustmentRequest $request
     * @return JsonResponse
     */
    public function store(StorePriceAdjustmentRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $PriceAdjustment = $this->PriceAdjustmentRepository->create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new PriceAdjustmentResource($PriceAdjustment)
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
     * @param UpdatePriceAdjustmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdatePriceAdjustmentRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $PriceAdjustment = $this->PriceAdjustmentRepository->update($id, $validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new PriceAdjustmentResource($PriceAdjustment)
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
            $this->PriceAdjustmentRepository->delete($id);
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
            $this->PriceAdjustmentRepository->forceDelete($id);
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
