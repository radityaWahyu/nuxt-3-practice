<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DayController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\JurusanController;
use App\Http\Controllers\Api\PembelajaranController;
use App\Http\Controllers\Api\AbsensiMengajarController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/get-user', [AuthController::class, 'getUser'])->name('get-user');
        Route::get('/helper/date-now', [HelperController::class, 'getTanggal'])->name('helper.tanggal');
        Route::get('/pembelajaran/by_user', [PembelajaranController::class, 'pembelajaranByUser'])->name('pembelajaran.user');

        Route::apiResource('/days', DayController::class);

        Route::controller(JurusanController::class)->group(function () {
            Route::prefix('jurusan')->group(function () {
                Route::get('/', 'index')->middleware('permission:read-jurusan|manage-jurusan')->name('jurusan.index');
                Route::post('/', 'store')->middleware('permission:read-jurusan|manage-jurusan')->name('jurusan.store');
                Route::get('/{jurusan}', 'show')->middleware('permission:manage-jurusan')->name('jurusan.show');
                Route::put('/{jurusan}', 'update')->middleware('permission:manage-jurusan')->name('jurusan.update');
                Route::delete('/{jurusan}', 'destroy')->middleware('permission:manage-jurusan')->name('jurusan.destroy');
            });
        });


        // Route::group(['middleware' => ['permission:read-jurusan']], function () {
        //     Route::apiResource('/jurusan', JurusanController::class)->only('index', 'store');
        // });

        // Route::group(['middleware' => ['permission:manage-jurusan']], function () {
        //     Route::apiResource('/jurusan', JurusanController::class)->only('index');
        // });

        Route::apiResource('/absensi_mengajar', AbsensiMengajarController::class);
    });

    //Route::apiResource('/pembelajaran', PembelajaranController::class);

});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
