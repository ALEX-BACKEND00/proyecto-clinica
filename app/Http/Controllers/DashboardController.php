<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Factura;

class DashboardController extends Controller
{
    public function index()
    {
        $citasHoy = Cita::whereDate('fecha', today())->count();

        $pacientesHoy = Paciente::whereDate('created_at', today())->count();

        $facturasHoy = Factura::whereDate('created_at', today())
            ->where('estado', 'pagada')
            ->sum('total');

        $proximasCitas = Cita::with('paciente')
            ->whereDate('fecha', '>=', today())
            ->orderBy('fecha')
            ->orderBy('hora')
            ->take(5)
            ->get();

        $facturasPendientes = Factura::where('estado', 'pendiente')->count();

        $facturasPagadas = Factura::where('estado', 'pagada')->count();

        $ingresoMensual = Factura::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('estado', 'pagada')
            ->sum('total');

        $ingresosMensuales = Factura::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('SUM(total) as total')
        )
        ->where('estado', 'pagada')
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $meses = [];
        $totales = [];

        foreach ($ingresosMensuales as $item) {
            $meses[] = $item->mes;
            $totales[] = $item->total;
        }

        $citasHoyList = Cita::with('paciente')
            ->whereDate('fecha', today())
            ->orderBy('hora')
            ->get();

        return view('dashboard', compact(
            'citasHoy',
            'pacientesHoy',
            'facturasHoy',
            'proximasCitas',
            'facturasPendientes',
            'facturasPagadas',
            'ingresoMensual',
            'meses',
            'totales',
            'citasHoyList'
        ));
    }
}