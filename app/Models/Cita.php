<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Cita.php
class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha',
        'hora',
        'motivo',
        'estado'
    ];

    // Accessor para obtener hora en formato H:i
    public function getHoraFormateadaAttribute()
    {
        return substr($this->hora, 0, 5);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}