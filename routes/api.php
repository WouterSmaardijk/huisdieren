<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PetTypeController;

Route::apiResource('pets', PetController::class)->only(['index', 'store', 'destroy']);
Route::get('pets/totals', [PetController::class, 'totals']);
Route::apiResource('pets/types', PetTypeController::class)->only(['index']);