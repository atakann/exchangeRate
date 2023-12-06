<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    private $apiKey = 'cur_live_fIAB19U0bLnTtQXzkUgDr0YyWwkMNylcgKaBvwq0';
    private $baseUrl = 'https://api.currencyapi.com/v3/latest';

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
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                'base_currency' => $pair[0],
                'currencies' => $pair[1],
            ]);

            if ($response->successful() && isset($response->json()['data'][$pair[1]])) {
                ExchangeRate::updateOrCreate(
                    [
                        'base_currency' => $pair[0],
                        'target_currency' => $pair[1]
                    ],
                    [
                        'rate' => $response->json()['data'][$pair[1]],
                    ]
                );
            } else {
                Log::error("Failed to fetch rates for {$pair[0]} to {$pair[1]}", ['response' => $response->body()]);
            }
        }
    }

    public function fetchTestRates()
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            'base_currency' => 'EUR',
            'currencies' => 'USD,GBP,JPY,TRY',
        ]);

        return $response->successful() ? $response->json() : null;
    }

    public function fetchLatestRates()
    {
        $pairs = [
            ['EUR', 'USD'],
            ['EUR', 'GBP'],
            ['GBP', 'USD'],
            ['USD', 'JPY'],
            ['USD', 'TRY'],
        ];

        $latestRates = [];

        foreach ($pairs as $pair) {
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                'base_currency' => $pair[0],
                'currencies' => $pair[1],
            ]);

            if ($response->successful() && isset($response->json()['data'][$pair[1]])) {
                $latestRates[] = [
                    'base_currency' => $pair[0],
                    'target_currency' => $pair[1],
                    'rate' => $response->json()['data'][$pair[1]],
                ];
            } else {
                return [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Failed to fetch rates for {$pair[0]} to {$pair[1]}"
                ];
            }
        }

        return [
            'status' => Response::HTTP_OK,
            'data' => $latestRates
        ];
    }
}
