<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
{
    $fecha = $request->fecha;
    $user = Auth::user();

    if ($user->role === 'admin') {

        $query = Cita::with('paciente');

    } else {

        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes paciente asociado.');
        }

        $query = Cita::with('paciente')
            ->where('paciente_id', $paciente->id);
    }

    if ($fecha) {
        $query->whereDate('fecha', $fecha);
    }

    $citas = $query
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->paginate(10);

    $puedeCrearCita = true;

    if ($user->role === 'paciente') {

        $puedeCrearCita = !Cita::where('paciente_id', $paciente->id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();
    }

    return view('citas.index', compact(
        'citas',
        'fecha',
        'puedeCrearCita'
    ));
}

    public function create()
{
    $user = Auth::user();

    if ($user->role === 'admin') {

        $pacientes = Paciente::orderBy('nombres')->get();
        $paciente_id = null;

    } else {

        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes paciente asociado.');
        }

        $pacientes = collect([$paciente]);
        $paciente_id = $paciente->id;
    }

    $fecha = now()->format('Y-m-d');

    return view('citas.create', compact(
        'pacientes',
        'paciente_id',
        'fecha'
    ));
}
public function estado(Request $request, Cita $cita)
{
    $request->validate([
        'estado' => 'required|in:confirmada,cancelada'
    ]);

    $cita->update([
        'estado' => $request->estado
    ]);

    return redirect()->route('dashboard')
        ->with('success', 'Estado de cita actualizado.');
}

    public function store(Request $request)
{
    $user = Auth::user();

    if ($user->role === 'paciente') {
        $request->merge([
            'paciente_id' => $user->paciente->id
        ]);
    }

    Cita::create($request->all());

    return redirect()->route('citas.index')
        ->with('success', 'Cita registrada correctamente');
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

    public function completar(Cita $cita)
    {
        $cita->update([
            'estado' => 'completada'
        ]);
        
        if ($cita->estado === 'cancelada') abort(403);

        return redirect(
            '/historias/create?paciente=' .
            $cita->paciente_id .
            '&fecha=' .
            $cita->fecha
        );
    }

    public function api()
    {
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
    }

    public function mover(Request $request)
    {
        $cita = Cita::findOrFail($request->id);

        $cita->update([
            'fecha' => date('Y-m-d', strtotime($request->start)),
            'hora'  => date('H:i:s', strtotime($request->start)),
        ]);

        return response()->json([
            'ok' => true
        ]);
    }
}
