<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsolidatedOrderController;



Route::prefix('consolidated-orders')->controller(ConsolidatedOrderController::class)->group(function () {
    Route::get('/', action: 'index');
    Route::get('/export', 'export');
    Route::get('/{id}', 'show');
    Route::post('/refresh',  'refresh');
});
