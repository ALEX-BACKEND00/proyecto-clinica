<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'paciente_id',
        'total',
        'estado',
        'descripcion'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}