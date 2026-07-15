<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        // Get all countries from database
        $countries = Country::all();

        return response()->json([
            'status' => 'success',
            'count' => $countries->count(),
            'data' => $countries
        ]);
    }
}