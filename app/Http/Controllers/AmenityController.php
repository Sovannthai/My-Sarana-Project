<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\AmenityResource;
use App\Repositories\AmenityRepository;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AmenityController extends Controller
{
    protected $amenityRepository;

    /**
     * AmenityController constructor.
     *
     * @param AmenityRepository $amenityRepository
     */
    public function __construct(AmenityRepository $amenityRepository)
    {
        $this->amenityRepository = $amenityRepository;
    }

    /**
     * Display a listing of the amenities.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $amenities = $this->amenityRepository->getAll();
        return response()->json([
            'status' => 'success',
            'data' => AmenityResource::collection($amenities)
        ]);
    }

    /**
     * Display the specified amenity.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $amenity = $this->amenityRepository->findById($id);
            return response()->json([
                'status' => 'success',
                'data' => new AmenityResource($amenity)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Store a newly created amenity in storage.
     *
     * @param StoreAmenityRequest $request
     * @return JsonResponse
     */
    public function store(StoreAmenityRequest $request): JsonResponse
    {
        $amenity = $this->amenityRepository->create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new AmenityResource($amenity)
        ], 201);
    }


    /**
     * Update the specified amenity in storage.
     *
     * @param UpdateAmenityRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAmenityRequest $request, int $id): JsonResponse
    {
        try {
            $amenity = $this->amenityRepository->update($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'data' => new AmenityResource($amenity)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Remove the specified amenity from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->amenityRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Amenity deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity not found'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Permanently remove the specified amenity from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $this->amenityRepository->forceDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Amenity permanently deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity not found'
            ], 404); // 404 Not Found
        }
    }
}
