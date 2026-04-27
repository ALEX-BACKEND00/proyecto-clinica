<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Factura;
use App\Models\Paciente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();

    if ($user->role === 'admin') {

        $query = Factura::with('paciente');

    } else {

        $query = Factura::with('paciente')
            ->whereHas('paciente', function ($q) use ($user) {
                $q->where('email', $user->email);
            });

    }

    $facturas = $query
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('facturas.index', compact(
        'facturas'
    ));
}

    public function create(Request $request)
{
    $pacientes = Paciente::orderBy('nombres')->get();

    $paciente_id = $request->paciente;

    return view('facturas.create', compact(
        'pacientes',
        'paciente_id'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'total' => 'required|numeric|min:0',
        ]);

        Factura::create($request->all());

        return redirect()->route('facturas.index')
            ->with('success', 'Factura creada correctamente');
    }

    public function edit(Factura $factura)
{
    if ($factura->estado === 'pagada') {
        return back()->with('error', 'Factura pagada no editable.');
    }

    $pacientes = Paciente::orderBy('nombres')->get();

    return view('facturas.edit', compact('factura', 'pacientes'));
}

    public function update(Request $request, Factura $factura)
{
    if ($factura->estado === 'pagada') {
        return back()->with('error', 'Factura pagada no editable.');
    }

    $request->validate([
        'paciente_id' => 'required',
        'total' => 'required|numeric|min:0',
    ]);

    $factura->update($request->all());

    return redirect()->route('facturas.index')
        ->with('success', 'Factura actualizada');
}

    public function destroy(Factura $factura)
{
    if ($factura->estado === 'pagada') {
        return back()->with('error', 'Factura pagada no eliminable.');
    }

    $factura->delete();

    return redirect()->route('facturas.index')
        ->with('success', 'Factura eliminada');
}
}