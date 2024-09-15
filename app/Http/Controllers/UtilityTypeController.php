<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UtilityTypeResource;
use App\Repositories\UtilityTypeRepository;
use App\Http\Requests\StoreUtilityTypeRequest;
use App\Http\Requests\UpdateUtilityTypeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UtilityTypeController extends Controller
{
    protected $UtilityTypeRepository;

    /**
     * UtilityTypeController constructor.
     *
     * @param UtilityTypeRepository $UtilityTypeRepository
     */
    public function __construct(UtilityTypeRepository $UtilityTypeRepository)
    {
        $this->UtilityTypeRepository = $UtilityTypeRepository;
    }

    /**
     * Display a listing of the UtilityTypes.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $UtilityTypes = $this->UtilityTypeRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => UtilityTypeResource::collection($UtilityTypes)
        ]);
    }

    /**
     * Display the specified UtilityType.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $UtilityType = $this->UtilityTypeRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new UtilityTypeResource($UtilityType)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'UtilityType not found'
            ], 404); // 404 Not Found
        }
    }

    public function store(StoreUtilityTypeRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $UtilityType = $this->UtilityTypeRepository->create($validated);

            // Attach amenities if provided
            if (isset($validated['amenities'])) {
                $UtilityType->amenities()->attach($validated['amenities']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new UtilityTypeResource($UtilityType)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create UtilityType',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateUtilityTypeRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $UtilityType = $this->UtilityTypeRepository->update($id, $validated);

            if (isset($validated['amenities'])) {
                $UtilityType->amenities()->sync($validated['amenities']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new UtilityTypeResource($UtilityType)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update UtilityType',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified UtilityType from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->UtilityTypeRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'UtilityType deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'UtilityType not found'
            ], 404);
        }
    }

    /**
     * Permanently remove the specified UtilityType from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->UtilityTypeRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'UtilityType permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'UtilityType not found'
            ], 404);
        }
    }
}
