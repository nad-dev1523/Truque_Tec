<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Asesoria;
use Laravel\Sanctum\HasApiTokens; // <--- 1. ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasFactory, Notifiable;


    /**
     * Campos que se pueden llenar al registrar o crear un usuario.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_rol',   // Para identificar si es Admin, Experto o Alumno
        'puntos',   // El saldo para el Trueque-Tec
    ];

    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casteo de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones con Asesorías
    |--------------------------------------------------------------------------
    */

    // Un usuario puede dar muchas asesorías (como experto)
    public function asesoriasComoExperto()
    {
        return $this->hasMany(Asesoria::class, 'id_experto');
    }

    // Un usuario puede recibir muchas asesorías (como alumno)
    public function asesoriasComoAlumno()
    {
        return $this->hasMany(Asesoria::class, 'id_alumno');
    }
}