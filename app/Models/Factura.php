<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Factura.php
class Factura extends Model
{
    protected $fillable = [
        'paciente_id',
        'total',
        'estado',
        'descripcion'
    ];

    // Formatear como COP (Colombian Pesos)
    public function getTotalFormateadoAttribute()
    {
        return '$ ' . number_format($this->total, 0, ',', '.');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}