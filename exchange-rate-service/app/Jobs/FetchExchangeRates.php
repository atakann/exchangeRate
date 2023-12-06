<?php

namespace App\Jobs;

use App\Services\ExchangeRateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // Initialization logic if required
    }

    public function handle()
    {
        $service = new ExchangeRateService();
        $service->fetchAndUpdateRates();
    
        // Re-dispatch the job for the next interval
        self::dispatch()->delay(now()->addMinutes(15));
    }
    
}