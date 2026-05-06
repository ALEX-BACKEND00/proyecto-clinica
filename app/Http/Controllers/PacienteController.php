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
    $request->merge([

        'nombres' => preg_replace('/\s+/', ' ', trim($request->nombres)),

        'apellidos' => preg_replace('/\s+/', ' ', trim($request->apellidos)),

        'documento' => preg_replace('/[^0-9]/', '', $request->documento),

        'telefono' => preg_replace('/[^0-9]/', '', $request->telefono),

        'email' => $request->email
            ? strtolower(trim($request->email))
            : null,

        'direccion' => $request->direccion
            ? preg_replace('/\s+/', ' ', trim($request->direccion))
            : null,
    ]);


    $data = $request->validate([

        'nombres' => [
            'required',
            'string',
            'min:2',
            'max:60',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\'-]+$/u'
        ],

        'apellidos' => [
            'required',
            'string',
            'min:2',
            'max:60',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\'-]+$/u'
        ],

        'documento' => [
            'required',
            'digits_between:6,11',
            'unique:pacientes,documento'
        ],

        'telefono' => [
            'required',
            'digits:10',
            'regex:/^3[0-9]{9}$/'
        ],

        'email' => [
            'nullable',
            'email',
            'max:120',
            'unique:users,email'
        ],

        'direccion' => [
            'required',
            'string',
            'min:5',
            'max:150'
        ],

        'fecha_nacimiento' => [
            'required',
            'date',
            'before_or_equal:today',
            'after:' . now()->subYears(120)->format('Y-m-d')
        ],

    ], [

        'documento.unique' => 'Ya existe un paciente con este documento.',
        'documento.digits_between' => 'El documento debe tener entre 6 y 11 dígitos.',

        'telefono.digits' => 'El celular debe tener 10 dígitos.',
        'telefono.regex' => 'Ingrese un celular colombiano válido.',

        'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',

        'nombres.regex' => 'Los nombres solo pueden contener letras.',
        'apellidos.regex' => 'Los apellidos solo pueden contener letras.',

    ]);


    DB::transaction(function () use ($data) {

        $user = User::create([
            'name' => $data['nombres'] . ' ' . $data['apellidos'],
            'email' => $data['email'] ?? $data['documento'] . '@paciente.local',
            'password' => Hash::make($data['documento']),
            'role' => 'paciente',
        ]);


        Paciente::create([
            'user_id' => $user->id,
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'documento' => $data['documento'],
            'telefono' => $data['telefono'],
            'email' => $data['email'] ?? null,
            'direccion' => $data['direccion'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
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
            'documento' => 'required|digits_between:6,11|unique:pacientes,documento,' . $paciente->id,
            'telefono' => [
    'required',
    'digits:10',
    'regex:/^3[0-9]{9}$/'
],
            'email' => 'nullable|email|max:120|unique:users,email,' . $paciente->user_id,
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