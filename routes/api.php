<?php

use App\Http\Controllers\ApiPCController;
use Illuminate\Support\Facades\Route;

Route::prefix('pc')->group(function () {
    Route::get('enable', [ApiPCController::class, 'enable']);
    Route::get('disable', [ApiPCController::class, 'disable']);
});
