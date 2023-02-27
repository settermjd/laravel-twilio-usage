<?php

use App\Http\Controllers\TwilioUsageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('twilio')->group(function () {
    Route::get(
        '/usage/{recordLimit}/{usageType?}',
        TwilioUsageController::class
    )
        ->whereIn('usageType', ['last_month', 'today', 'all_time'])
        ->name('usage');
});
