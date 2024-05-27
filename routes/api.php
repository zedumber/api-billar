<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\TiempoMesaController;
use App\Models\Configuration;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ESP32Controller;

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

Route::group([
 
    // 'middleware' => 'auth:api',
    'prefix' => 'auth'
 
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');


});

Route::get('tiempos', [TiempoMesaController::class, 'index']);
Route::post('mesas', [MesaController::class, 'crearMesa']);
Route::post('tiempos', [TiempoMesaController::class, 'guardartiempo']);
Route::put('tiempo-mesas/{id}/marcar-pagado', [TiempoMesaController::class, 'marcarPagado']);


Route::get('/config/wifi', [ConfigurationController::class, 'getWiFiConfiguration']);
Route::get('/config/price', [ConfigurationController::class, 'getPriceConfiguration']);
Route::post('/config/save', [ConfigurationController::class, 'saveConfiguration']);


Route::post('/esp32/status', [ESP32Controller::class, 'updateStatus']);
Route::get('/esp32/inactivity', [ESP32Controller::class, 'checkInactivity']);