<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetType;

class PetTypeController extends Controller
{
    function index()
    {
        return response()->json(PetType::all());
    }
}
