<?php

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login", [LoginController::class, "alterLogin"])->name("api.login");

Route::post("/register", [RegisterController::class, "registerFrontend"])->name("api.register");

Route::post("/check-email", [RegisterController::class, "checkEmail"])->name("api.check.email");

Route::post("/jobStatusToggle", [JobController::class, "toggleJobStatus"])->name("api.jobs.toggle");

Route::get("/cities", [CityController::class, "cities"])->name("api.list.cities");


