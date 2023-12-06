<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $latestRates = ExchangeRate::latest('updated_at')->take(5)->get();
        return response()->json($latestRates);
    }
}
