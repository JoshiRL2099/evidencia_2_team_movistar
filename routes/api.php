<?php

use App\Http\Controllers\Api\PublicOrderController;
use Illuminate\Support\Facades\Route;

Route::post('/public/orders/lookup', [PublicOrderController::class, 'lookup']);