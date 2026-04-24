<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HistoriaClinica;
use App\Models\Paciente;
use Illuminate\Http\Request;
class HistoriaClinicaController extends Controller
{
public function paciente(Paciente $paciente)
{
    $historias = $paciente->historias()
        ->latest()
        ->get();

    $proximaCita = $paciente->citas()
        ->whereDate('fecha', '>=', today())
        ->orderBy('fecha')
        ->orderBy('hora')
        ->first();

    $facturasPendientes = $paciente->facturas()
        ->where('estado', 'pendiente')
        ->count();

    $alertas = [];

    // cita hoy
    $citaHoy = $paciente->citas()
        ->whereDate('fecha', today())
        ->exists();

    if ($citaHoy) {
        $alertas[] = [
            'tipo' => 'info',
            'texto' => 'Paciente tiene cita programada hoy.'
        ];
    }

    // facturas pendientes
    if ($facturasPendientes > 0) {
        $alertas[] = [
            'tipo' => 'warning',
            'texto' => 'Tiene facturas pendientes.'
        ];
    }

    // sin odontograma
    if ($paciente->odontogramas()->count() == 0) {
        $alertas[] = [
            'tipo' => 'danger',
            'texto' => 'Paciente sin odontograma registrado.'
        ];
    }

    // paciente nuevo
    if ($historias->count() == 0) {
        $alertas[] = [
            'tipo' => 'info',
            'texto' => 'Paciente nuevo sin historial clínico.'
        ];
    }

    // inactivo 6 meses
    if ($historias->count() > 0) {

        $ultima = $historias->first()->fecha;

        if (\Carbon\Carbon::parse($ultima)->lt(now()->subMonths(6))) {
            $alertas[] = [
                'tipo' => 'warning',
                'texto' => 'Paciente sin atención hace más de 6 meses.'
            ];
        }
    }

    return view('historias.paciente', compact(
        'paciente',
        'historias',
        'proximaCita',
        'facturasPendientes',
        'alertas'
    ));
}
    public function index()
{
    $user = Auth::user();

    if ($user->role !== 'paciente') {
        return redirect()->route('dashboard');
    }

    $paciente = $user->paciente;

    if (!$paciente) {
        return redirect()->route('dashboard')
            ->with('error', 'No tienes paciente vinculado.');
    }

    $historias = HistoriaClinica::where('paciente_id', $paciente->id)
        ->latest()
        ->paginate(10);

    return view('historias.index', compact('historias', 'paciente'));
}

public function create(Request $request)
{
    $pacientes = Paciente::orderBy('nombres')->get();

    $paciente_id = $request->paciente;
    $fecha = $request->fecha ?? now()->format('Y-m-d');

    return view('historias.create', compact(
        'pacientes',
        'paciente_id',
        'fecha'
    ));
}

    public function store(Request $request)
{
    $historia = HistoriaClinica::create($request->all());

    return redirect()->route(
        'pacientes.historia',
        $historia->paciente_id
    )->with('success', 'Evolución clínica registrada correctamente');
}

    public function edit(HistoriaClinica $historia)
    {
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('historias.edit', compact('historia','pacientes'));
    }

    public function update(Request $request, HistoriaClinica $historia)
    {
        $historia->update($request->all());

        return redirect()->route('historias.index')
            ->with('success','Historia actualizada');
    }

    public function destroy(HistoriaClinica $historia)
    {
        $historia->delete();

        return back()->with('success','Historia eliminada');
    }
}