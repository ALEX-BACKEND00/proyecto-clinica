<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $pacientes = Paciente::where('nombres', 'like', "%$buscar%")
            ->orWhere('apellidos', 'like', "%$buscar%")
            ->orWhere('documento', 'like', "%$buscar%")
            ->latest()
            ->paginate(8);

        return view('pacientes.index', compact('pacientes', 'buscar'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'documento' => 'required|unique:pacientes',
            'telefono' => 'required',
        ]);

        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente creado correctamente');
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'documento' => 'required|unique:pacientes,documento,' . $paciente->id,
            'telefono' => 'required',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado');
    }
}