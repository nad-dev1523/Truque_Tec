<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    protected $fillable = [
        'experto_id',
        'alumno_id',
        'materia',
        'fecha',
        'descripcion',
        'estado'
    ];

    public function experto()
    {
        return $this->belongsTo(User::class, 'experto_id');
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }
}