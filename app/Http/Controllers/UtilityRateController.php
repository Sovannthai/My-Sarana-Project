<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UtilityRateResource;
use App\Repositories\UtilityRateRepository;
use App\Http\Requests\StoreUtilityRateRequest;
use App\Http\Requests\UpdateUtilityRateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UtilityRateController extends Controller
{
    protected $utilityRateRepository;

    /**
     * UtilityRateController constructor.
     *
     * @param UtilityRateRepository $utilityRateRepository
     */
    public function __construct(UtilityRateRepository $utilityRateRepository)
    {
        $this->utilityRateRepository = $utilityRateRepository;
    }

    /**
     * Display a listing of the utility rates.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $utilityRates = $this->utilityRateRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => UtilityRateResource::collection($utilityRates)
        ]);
    }

    /**
     * Display the specified utility rate.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $utilityRate = $this->utilityRateRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new UtilityRateResource($utilityRate)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utility rate not found'
            ], 404);
        }
    }

    /**
     * Store a newly created utility rate in storage.
     *
     * @param StoreUtilityRateRequest $request
     * @return JsonResponse
     */
    public function store(StoreUtilityRateRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $utilityRate = $this->utilityRateRepository->create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new UtilityRateResource($utilityRate)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create utility rate',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified utility rate in storage.
     *
     * @param UpdateUtilityRateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUtilityRateRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $utilityRate = $this->utilityRateRepository->update($id, $validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new UtilityRateResource($utilityRate)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update utility rate',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified utility rate from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->utilityRateRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Utility rate deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utility rate not found'
            ], 404);
        }
    }

    /**
     * Permanently remove the specified utility rate from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->utilityRateRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Utility rate permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utility rate not found'
            ], 404);
        }
    }
}
