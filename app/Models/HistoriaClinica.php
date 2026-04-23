<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha',
        'odontologo',
        'motivo_consulta',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'proximo_control'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
