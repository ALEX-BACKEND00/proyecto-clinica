<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
public function index(Request $request)
{
    $fecha = $request->fecha;

    $citas = Cita::with('paciente')
        ->when($fecha, function ($query) use ($fecha) {
            $query->whereDate('fecha', $fecha);
        })
        ->orderBy('fecha')
        ->orderBy('hora')
        ->paginate(10);

    return view('citas.index', compact('citas', 'fecha'));
}

    public function create()
    {
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('citas.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')
            ->with('success', 'Cita agendada correctamente');
    }

    public function edit(Cita $cita)
    {
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('citas.edit', compact('cita', 'pacientes'));
    }

    public function update(Request $request, Cita $cita)
    {
        $cita->update($request->all());

        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada');
    }
}