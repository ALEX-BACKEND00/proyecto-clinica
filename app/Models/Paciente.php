<?php

namespace App\Models;

use App\Models\HistoriaClinica;
use App\Models\Odontograma;
use App\Models\Factura;
use App\Models\Cita;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}
    public function historias()
{
    return $this->hasMany(HistoriaClinica::class);
}
    public function odontogramas()
{
    return $this->hasMany(Odontograma::class);
}
    public function facturas()
{
    return $this->hasMany(Factura::class);
}
    public function citas()
{
    return $this->hasMany(Cita::class);
}
    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'documento',
        'telefono',
        'email',
        'direccion',
        'fecha_nacimiento'
        
    ];
}
