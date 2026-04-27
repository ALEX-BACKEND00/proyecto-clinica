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
    if(in_array($cita->estado, ['completada','cancelada'])){
        return back()->with('error','Esta cita ya no puede editarse.');
    }

    $cita->update($request->all());

    if($request->estado === 'completada'){
        return redirect(
            '/pacientes/' . $cita->paciente_id . '/odontograma'
        );
    }

    return redirect()->route('citas.index')
        ->with('success','Cita actualizada');
}

    public function destroy(Cita $cita)
{
    if(in_array($cita->estado, ['completada','cancelada'])){
        return back()->with('error','Esta cita no puede eliminarse.');
    }

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

    /**
     * Devuelve color hexadecimal según tipo de cita
     */
    private function getColorByTipo($tipo)
    {
        $colores = [
            'consulta' => '#3b82f6',      // azul
            'limpieza' => '#10b981',      // verde
            'ortodoncia' => '#f59e0b',    // ámbar
            'cirugia' => '#ef4444',       // rojo
            'urgencia' => '#dc2626',      // rojo oscuro
            'seguimiento' => '#8b5cf6',   // morado
            'tratamiento' => '#06b6d4',   // cyan
            'evaluacion' => '#6366f1',    // indigo
        ];

        return $colores[strtolower($tipo)] ?? '#6b7280'; // gris por defecto
    }
public function hoy()
{
    $citas = Cita::with('paciente')
        ->where('fecha', now()->format('Y-m-d'))
        ->orderBy('hora', 'asc')
        ->get();
    
    return response()->json($citas->map(function($cita) {
        return [
            'id' => $cita->id,
            'paciente' => [
                'nombres' => $cita->paciente->nombres,
                'apellidos' => $cita->paciente->apellidos
            ],
            'hora' => $cita->hora,
            'estado' => $cita->estado
        ];
    }));
}
    public function api()
{
    $citas = Cita::with('paciente')
        ->where('fecha', '>=', now()->startOfMonth())
        ->get();
    
    return response()->json($citas->map(function($cita) {
        return [
            'id' => $cita->id,
            'title' => $cita->paciente ? ($cita->paciente->nombres . ' ' . $cita->paciente->apellidos) : 'Sin paciente',
            'start' => $cita->fecha . 'T' . $cita->hora,
            'end' => $cita->hora_fin ? $cita->fecha . 'T' . $cita->hora_fin : null,
            'backgroundColor' => $this->getColorByTipo($cita->tipo),
            'borderColor' => $this->getColorByTipo($cita->tipo),
            'extendedProps' => [
                'paciente' => $cita->paciente,
                'paciente_id' => $cita->paciente_id,  // ← NUEVO
                'tipo' => $cita->tipo,
                'estado' => $cita->estado,
                'motivo' => $cita->motivo,
                'observaciones' => $cita->observaciones,
                'color' => $this->getColorByTipo($cita->tipo)
            ]
        ];
    }));
}

    public function mover(Request $request)
{
    $cita = Cita::findOrFail($request->id);

    $cita->update([
        'fecha' => date('Y-m-d', strtotime($request->start)),
        'hora'  => date('H:i:s', strtotime($request->start)),
    ]);

    return response()->json([
        'success' => true   // ✅ Cambiar 'ok' a 'success'
    ]);
}
}