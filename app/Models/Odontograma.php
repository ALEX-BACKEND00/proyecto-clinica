<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    protected $fillable = ['paciente_id','observaciones'];

public function detalles()
{
    return $this->hasMany(OdontogramaDetalle::class);
}

public function paciente()
{
    return $this->belongsTo(Paciente::class);
}
}
