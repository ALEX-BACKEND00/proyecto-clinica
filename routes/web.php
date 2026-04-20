<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\FacturaController;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Factura;


Route::get('/api/citas', function () {

    return Cita::with('paciente')
        ->get()
        ->map(function ($cita) {
            return [
                'id' => $cita->id,
                'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos,
                'start' => $cita->fecha . 'T' . $cita->hora,
                'extendedProps' => [
                    'estado' => $cita->estado
                ]
            ];
        });

})->middleware(['auth']);

Route::post('/api/citas/mover', function (Request $request) {

    $cita = Cita::findOrFail($request->id);

    $cita->update([
        'fecha' => date('Y-m-d', strtotime($request->start)),
        'hora' => date('H:i:s', strtotime($request->start)),
    ]);

    return response()->json(['ok' => true]);

})->middleware(['auth']);

Route::resource('facturas', FacturaController::class)
    ->middleware(['auth']);

Route::resource('citas', CitaController::class)
    ->middleware(['auth']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $citasHoy = Cita::whereDate('fecha', today())->count();

    $pacientesHoy = Paciente::whereDate('created_at', today())->count();


    $facturasHoy = Factura::whereDate('created_at', today())
        ->where('estado', 'pagada')
        ->sum('total');

    $proximasCitas = Cita::with('paciente')
        ->whereDate('fecha', '>=', today())
        ->orderBy('fecha')
        ->orderBy('hora')
        ->take(5)
        ->get();
    $facturasPendientes = Factura::where('estado', 'pendiente')->count();

    $facturasPagadas = Factura::where('estado', 'pagada')->count();

    $ingresoMensual = Factura::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->where('estado', 'pagada')
        ->sum('total');
    $ingresosMensuales = Factura::select(
        DB::raw('MONTH(created_at) as mes'),
        DB::raw('SUM(total) as total')
    )
        ->where('estado', 'pagada')
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();
    $meses = [];
    $totales = [];

    foreach ($ingresosMensuales as $item) {
        $meses[] = $item->mes;
        $totales[] = $item->total;
    }
    $citasHoyList = Cita::with('paciente')
        ->whereDate('fecha', today())
        ->orderBy('hora')
        ->get();

    return view('dashboard', compact(
        'citasHoy',
        'pacientesHoy',
        'facturasHoy',
        'proximasCitas',
        'facturasPendientes',
        'facturasPagadas',
        'ingresoMensual',
        'meses',
        'totales',
        'citasHoyList',
    ));

})->middleware(['auth'])->name('dashboard');

Route::resource('pacientes', PacienteController::class)
    ->middleware(['auth']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
