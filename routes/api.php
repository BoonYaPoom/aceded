<?php

use App\Http\Controllers\API\ApiTofontController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/departmentapi', [ApiController::class, 'apiDepartment']);
Route::get('/apiUsers', [ApiController::class, 'apiUsers']);
Route::post('/web/provinces', [ApiTofontController::class, 'provinces']);
Route::post('/web/districts', [ApiTofontController::class, 'districts']);
Route::post('/web/subdistricts', [ApiTofontController::class, 'subdistricts']);
Route::get('/usersapina', [ApiTofontController::class, 'usersapina']);
