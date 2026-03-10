<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    use HasFactory;

    protected $table = 'asesorias';
    protected $primaryKey = 'id_asesoria';


    protected $fillable = [
        'id_experto',
        'id_alumno',
        'id_lugar',
        'materia',
        'fecha',
        'hora_ini',
        'hora_fin',
        'descripcion',
        'id_asistencia',
        'estado',
    ];

    // Relaciones 
    public function experto()
    {
        return $this->belongsTo(User::class, 'id_experto');
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'id_alumno');
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar');
    }
}