<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\OdontogramaController;
use App\Http\Controllers\HistoriaClinicaController;

/*
|--------------------------------------------------------------------------
| PUBLICO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| PRIVADO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PACIENTES
    |--------------------------------------------------------------------------
    */

    Route::resource('pacientes', PacienteController::class);

    Route::get('/pacientes/{paciente}/historia',
        [HistoriaClinicaController::class, 'paciente'])
        ->name('pacientes.historia');

    Route::get('/pacientes/{paciente}/odontograma',
        [OdontogramaController::class, 'index'])
        ->name('pacientes.odontograma');

    Route::post('/odontograma/guardar',
        [OdontogramaController::class, 'guardar'])
        ->name('odontograma.guardar');

    /*
    |--------------------------------------------------------------------------
    | CITAS
    |--------------------------------------------------------------------------
    */

    Route::resource('citas', CitaController::class);

    Route::post('/citas/{cita}/completar',
        [CitaController::class, 'completar'])
        ->name('citas.completar');

    Route::get('/api/citas',
        [CitaController::class, 'api'])
        ->name('api.citas');

    Route::post('/api/citas/mover',
        [CitaController::class, 'mover'])
        ->name('api.citas.mover');

    /*
    |--------------------------------------------------------------------------
    | FACTURACIÓN
    |--------------------------------------------------------------------------
    */

    Route::resource('facturas', FacturaController::class);

    /*
    |--------------------------------------------------------------------------
    | HISTORIA CLÍNICA
    |--------------------------------------------------------------------------
    */

    Route::resource('historias', HistoriaClinicaController::class);

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';