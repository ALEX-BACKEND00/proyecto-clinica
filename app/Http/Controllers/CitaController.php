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
public function horariosDisponibles(Request $request)
{
    $fecha = $request->fecha;

    $dia = date('w', strtotime($fecha)); // 0 domingo

    $horarios = [];

    // Lunes a viernes
    if($dia >= 1 && $dia <= 5){

        $horarios = [
            '08:00','08:30','09:00','09:30',
            '10:00','10:30','11:00','11:30',
            '14:00','14:30','15:00','15:30',
            '16:00','16:30','17:00','17:30'
        ];
    }

    // sábado
    if($dia == 6){

        $horarios = [
            '08:00','08:30','09:00','09:30',
            '10:00','10:30','11:00','11:30'
        ];
    }

    // domingo cerrado
    if($dia == 0){
        return response()->json([]);
    }

    $ocupadas = Cita::whereDate('fecha', $fecha)
        ->whereIn('estado', ['pendiente','confirmada'])
        ->pluck('hora')
        ->map(fn($h) => substr($h,0,5))
        ->toArray();

    $libres = array_values(array_diff($horarios, $ocupadas));

    return response()->json($libres);
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
    public function api(Request $request)
{
    $inicio = $request->start;
    $fin = $request->end;

    $citas = Cita::with('paciente')
        ->whereDate('fecha', '>=', $inicio)
        ->whereDate('fecha', '<=', $fin)
        ->get();

    return response()->json(
        $citas->map(function ($cita) {
            return [
                'id' => $cita->id,
                'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos,
                'start' => $cita->fecha . 'T' . $cita->hora,  // ← FIX: concatenar fecha y hora
                'allDay' => false,  // Asegurar que no es evento de día completo
                'color' => $this->colorEstado($cita->estado),
                'extendedProps' => [
                    'paciente_id' => $cita->paciente_id,
                    'hora_original' => $cita->hora,
                    'estado' => $cita->estado,
                    'motivo' => $cita->motivo
                ]
            ];
        })
    );
}

    private function colorEstado($estado)
{
    return match($estado) {
        'pendiente' => '#f59e0b',
        'confirmada' => '#3b82f6',
        'completada' => '#10b981',
        'cancelada' => '#ef4444',
        default => '#6b7280',
    };
}

    public function mover(Request $request)
    {
        \Log::info('Mover cita request:', $request->all());

        $request->validate([
            'id' => 'required|exists:citas,id',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i:s'  // Formato 24h
        ]);

        $cita = Cita::findOrFail($request->id);

        \Log::info('Cita antes de update:', ['fecha' => $cita->fecha, 'hora' => $cita->hora]);

        $cita->update([
            'fecha' => $request->fecha,
            'hora'  => $request->hora ?: date('H:i:s', strtotime($request->fecha . ' 08:00:00')), // Si no hay hora, usa 8am
        ]);

        \Log::info('Cita después de update:', ['fecha' => $cita->fecha, 'hora' => $cita->hora]);

        return response()->json([
            'success' => true,
            'message' => 'Cita reprogramada correctamente'
        ]);
    }
}