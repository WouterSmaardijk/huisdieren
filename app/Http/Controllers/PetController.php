<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Get a list of pets with their type.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Pet::with('type')
            ->orderBy('name')
            ->paginate(10)
            ->toArray());
    }

    /**
     * Show the total amount of pets for each type.
     * @return JsonResponse
     */
    public function totals(): JsonResponse
    {
        $totals = PetType::select('name as species')
            ->withCount('pets')
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($petType) {
                return [
                    'species' => $petType->species,
                    'amount' => $petType->pets_count,
                ];
            });
        return response()->json($totals, 200);
    }

    /**
     * Store a newly created pet in the database.
     * @param Request $request The request object.
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'type_id' => 'required|integer|exists:pet_types,id',
                'address' => 'required|string|max:255',
            ]);
            
            $pet = Pet::create($validatedData);

            return response()->json($pet, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Perform a soft delete on the specified pet.
     * @param Pet $pet The pet to delete.
     * @return JsonResponse
     */
    public function destroy(Pet $pet): JsonResponse
    {
        $pet->delete();
        return response()->json(['message' => 'Pet ' . $pet->name . ' deleted successfully'], 200);
    }
}
