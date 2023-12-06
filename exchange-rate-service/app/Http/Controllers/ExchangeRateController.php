<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Http\Response;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $latestRates = ExchangeRate::latest('updated_at')->take(5)->get();
        return response()->json($latestRates);
    }

    public function fetchAndStoreRates(ExchangeRateService $service)
    {
        $result = $service->fetchLatestRates();
    
        if (isset($result['status']) && $result['status'] !== Response::HTTP_OK) {
            return response()->json(['message' => $result['message']], $result['status']);
        }
    
        foreach ($result['data'] as $rate) {
            // Ensure that only the numerical value is stored in the 'rate' column
            $rateValue = is_array($rate['rate']) ? $rate['rate']['value'] : $rate['rate'];
    
            ExchangeRate::updateOrCreate(
                ['base_currency' => $rate['base_currency'], 'target_currency' => $rate['target_currency']],
                ['rate' => $rateValue]
            );
        }
    
        return response()->json($result['data'], Response::HTTP_OK);
    }
    

}
