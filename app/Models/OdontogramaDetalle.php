<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OdontogramaDetalle extends Model
{
    protected $fillable = ['odontograma_id','pieza','estado'];

public function odontograma()
{
    return $this->belongsTo(Odontograma::class);
}
}
