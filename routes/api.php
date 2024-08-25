<?php

use App\Models\Wave;
use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::get('/program-studi', function () {
    return new ApiResource(200, 'LIST_PRODI', Prodi::where('status', 1)->get());
});

Route::get('/kelas', function () {
    return new ApiResource(200, 'LIST_KELAS', Kelas::all());
});

Route::get('/gelombang', function () {
    return new ApiResource(200, 'LIST_GELOMBANG', Wave::getActiveData());
});
