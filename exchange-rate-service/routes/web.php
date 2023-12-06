<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\FetchExchangeRates;
use App\Services\ExchangeRateService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-api', function () {
    $service = new ExchangeRateService();
    return $service->fetchTestRates(); // This will be a new method in your service for testing
});

Route::get('/dispatch-exchange-rates', function () {
    FetchExchangeRates::dispatch();
    return 'Job dispatched!';
});