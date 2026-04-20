<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Paciente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('paciente')
            ->latest()
            ->paginate(10);

        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('facturas.create', compact('pacientes'));
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
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('facturas.edit', compact('factura', 'pacientes'));
    }

    public function update(Request $request, Factura $factura)
    {
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
        $factura->delete();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada');
    }
}