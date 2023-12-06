<?php

namespace App\Services;

use App\Models\ExchangeRate;
use \FreeCurrencyApi\FreeCurrencyApi\FreeCurrencyApiClient;

class ExchangeRateService
{
    protected $apiClient;

    public function __construct()
    {
        $this->apiClient = new FreeCurrencyApiClient('fca_live_hd9bVAnCHEA7VAq4zsBWaknaI1jeGjN2UPs30hdL');
    }

    public function fetchAndUpdateRates()
    {
        $pairs = [
            ['EUR', 'USD'],
            ['EUR', 'GBP'],
            ['GBP', 'USD'],
            ['USD', 'JPY'],
            ['USD', 'TRY'],
        ];

        foreach ($pairs as $pair) {
            $response = $this->apiClient->latest([
                'base_currency' => $pair[0],
                'currencies' => $pair[1],
            ]);

            if (isset($response['data'][$pair[1]])) {
                ExchangeRate::updateOrCreate(
                    [
                        'base_currency' => $pair[0],
                        'target_currency' => $pair[1]
                    ],
                    [
                        'rate' => $response['data'][$pair[1]],
                    ]
                );
            }
        }
    }

    public function fetchTestRates()
    {
        $response = $this->apiClient->latest([
            'base_currency' => 'EUR',
            'currencies' => 'USD,GBP,JPY,TRY',
        ]);

        return $response; // Return the raw response for testing
    }    
}
