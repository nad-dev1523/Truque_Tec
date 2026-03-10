<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleAsistencia extends Model
{
    protected $table = 'detalle_asistencia';
    protected $primaryKey = 'id_asisten_as';
    protected $fillable = ['id_as', 'id_usuario'];

    public function asesoria() {
        return $this->belongsTo(Asesoria::class, 'id_as');
    }
}