<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Odontograma;

class OdontogramaController extends Controller
{
    public function index(Paciente $paciente)
    {
        $odontograma = $paciente->odontogramas()
            ->with('detalles')
            ->latest()
            ->first();

        $estados = [];

        if ($odontograma) {
            foreach ($odontograma->detalles as $detalle) {
                $estados[$detalle->pieza] = $detalle->estado;
            }
        }

        return view('odontograma.index', compact(
            'paciente',
            'odontograma',
            'estados'
        ));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'dientes'     => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $odontograma = Odontograma::updateOrCreate(
                [
                    'paciente_id' => $request->paciente_id
                ],
                [
                    'observaciones' => $request->observaciones
                ]
            );

            $odontograma->detalles()->delete();

            foreach ($request->dientes as $pieza => $estado) {
                $odontograma->detalles()->create([
                    'pieza'  => $pieza,
                    'estado' => $estado
                ]);
            }
        });

        return redirect()
            ->route('pacientes.odontograma', $request->paciente_id)
            ->with('success', 'Odontograma actualizado correctamente.');
    }
}