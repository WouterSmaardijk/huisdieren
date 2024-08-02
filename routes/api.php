<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::apiResource('pets', PetController::class)->only(['index', 'store', 'destroy']);
Route::get('pets/totals', [PetController::class, 'totals']);