<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('families', FamilyController::class)
    ->scoped([
        'family' => 'name',
    ])
    ->missing(function () {
        return response()->json([
            'message' => 'Family not found.',
        ], 404);
    });
