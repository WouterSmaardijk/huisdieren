<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Pet::with('type')->orderBy('name')->paginate(10)->toArray());
    }

    /**
     * Show the total amount of pets for each type.
     */
    public function totals()
    {
       
        $totals = DB::table('pets')
        ->select('pet_types.name as species', DB::raw('count(pets.type_id) as amount'))
        ->join('pet_types', 'pets.type_id', '=', 'pet_types.id')
        ->whereNull('pets.deleted_at')
        ->whereNull('pet_types.deleted_at')
        ->groupBy('pets.type_id', 'pet_types.name')
        ->get();

        return response()->json($totals, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'type_id' => 'required|integer|exists:pet_types,id',
                'address' => 'required|string|max:255',
            ]);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }

        $pet = Pet::create($validatedData);

        return response()->json($pet, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet): JsonResponse
    {
        $pet->delete();
        return response()->json(['message' => 'Pet ' . $pet->name . ' deleted successfully'], 200);
    }
}
