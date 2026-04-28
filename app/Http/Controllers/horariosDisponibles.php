<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class horariosDisponibles extends Controller
{
    public function horariosDisponibles(Request $request)
{
    $fecha = $request->fecha;

    $horarios = [
        '08:00','08:30','09:00','09:30',
        '10:00','10:30','11:00','11:30',
        '14:00','14:30','15:00','15:30',
        '16:00','16:30','17:00','17:30'
    ];

    $ocupadas = Cita::whereDate('fecha', $fecha)
        ->whereIn('estado',['pendiente','confirmada'])
        ->pluck('hora')
        ->map(fn($h)=>substr($h,0,5))
        ->toArray();

    $libres = array_values(array_diff($horarios, $ocupadas));

    return response()->json($libres);
}
}
