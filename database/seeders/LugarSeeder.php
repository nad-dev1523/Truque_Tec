<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LugarSeeder extends Seeder
{
    public function run(): void
    {
        $lugares = [
            ['nombre_lugar' => 'Docencia 1 - Planta baja'],
            ['nombre_lugar' => 'Docencia 2 - planta alta'],
            ['nombre_lugar' => 'Biblioteca'],
            ['nombre_lugar' => 'Cafetería'],
            ['nombre_lugar' => 'Auditorio Doc 3'],
            ['nombre_lugar' => 'Canchas Deportivas'],
            ['nombre_lugar' => 'palapas'],
        ];

        foreach ($lugares as $lugar) {
            DB::table('lugares')->insert([
                'nombre_lugar' => $lugar['nombre_lugar'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}