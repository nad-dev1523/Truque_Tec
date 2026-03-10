<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';
    protected $primaryKey = 'id_lugar';
    
    protected $fillable = ['nombre_lugar'];

    // Un lugar puede tener muchas asesorías
    public function asesorias()
    {
        return $this->hasMany(Asesoria::class, 'id_lugar');
    }

    // Dentro de App\Models\Asesoria.php
    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar');
    }
}