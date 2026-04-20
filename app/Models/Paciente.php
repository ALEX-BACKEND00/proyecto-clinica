<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public function facturas()
{
    return $this->hasMany(Factura::class);
}
    public function citas()
{
    return $this->hasMany(Cita::class);
}
    protected $fillable = [
        'nombres',
        'apellidos',
        'documento',
        'telefono',
        'email',
        'direccion',
        'fecha_nacimiento'
    ];
}
