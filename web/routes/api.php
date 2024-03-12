<?php

use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\PartnerApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\SettingApiController;
use App\Http\Controllers\Api\WorkCaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LanguageApiController;
use App\Http\Controllers\Api\LocalizationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/translations/{locale?}', [LocalizationController::class, 'translations']);
Route::apiResource('languages', LanguageApiController::class)->only(['index']);
Route::apiResource('menus', MenuApiController::class)->only(['index']);
Route::apiResource('partners', PartnerApiController::class)->only(['index']);
Route::apiResource('work-cases', WorkCaseApiController::class)->only(['index']);
Route::apiResource('settings', SettingApiController::class)->only(['index']);
Route::apiResource('services', ServiceApiController::class)->only(['index']);
Route::apiResource('blog', BlogApiController::class)->only(['index']);

