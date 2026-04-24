<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $pacientes = Paciente::with('user')
            ->where(function ($query) use ($buscar) {
                $query->where('nombres', 'like', "%$buscar%")
                    ->orWhere('apellidos', 'like', "%$buscar%")
                    ->orWhere('documento', 'like', "%$buscar%");
            })
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
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'documento' => 'required|string|max:50|unique:pacientes,documento',
            'telefono' => 'required|string|max:30',
            'email' => 'nullable|email|max:150|unique:users,email',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        DB::transaction(function () use ($data) {

            // 1. Crear usuario del sistema
            $user = User::create([
                'name' => $data['nombres'] . ' ' . $data['apellidos'],
                'email' => $data['email'] ?? $data['documento'] . '@paciente.local',
                'password' => Hash::make($data['documento']), // temporal controlado
                'role' => 'paciente',
            ]);

            // 2. Crear paciente vinculado
            Paciente::create([
                'user_id' => $user->id,
                'nombres' => $data['nombres'],
                'apellidos' => $data['apellidos'],
                'documento' => $data['documento'],
                'telefono' => $data['telefono'],
                'email' => $data['email'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            ]);
        });

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente y usuario creados correctamente');
    }

    public function edit(Paciente $paciente)
    {
        $paciente->load('user');

        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'documento' => 'required|string|max:50|unique:pacientes,documento,' . $paciente->id,
            'telefono' => 'required|string|max:30',
            'email' => 'nullable|email|max:150|unique:users,email,' . $paciente->user_id,
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        DB::transaction(function () use ($data, $paciente) {

            // actualizar paciente
            $paciente->update($data);

            // actualizar usuario relacionado
            if ($paciente->user) {
                $paciente->user->update([
                    'name' => $data['nombres'] . ' ' . $data['apellidos'],
                    'email' => $data['email'] ?? $paciente->user->email,
                ]);
            }
        });

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente');
    }

    public function destroy(Paciente $paciente)
    {
        DB::transaction(function () use ($paciente) {

            // elimina usuario también
            if ($paciente->user) {
                $paciente->user->delete();
            }

            $paciente->delete();
        });

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente');
    }
}