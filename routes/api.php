<?php

use App\Http\Controllers\ApiPCController;
use Illuminate\Support\Facades\Route;

Route::prefix('pc')->group(function () {
    Route::get('{status}/change', [ApiPCController::class, 'change']);
    Route::get('check', [ApiPCController::class, 'check']);
});
