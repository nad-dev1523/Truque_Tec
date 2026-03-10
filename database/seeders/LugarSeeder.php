<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LugarSeeder extends Seeder
{
    public function run(): void
    {
        $lugares = [
            ['nombre_lugar' => 'Biblioteca'],
            ['nombre_lugar' => 'Laboratorio de Cómputo D1'],
            ['nombre_lugar' => 'Laboratorio de Cómputo D2'],
            ['nombre_lugar' => 'Palapas'],
            ['nombre_lugar' => 'Auditorio'],
            ['nombre_lugar' => 'Sala de Juntas DSM'],
        ];

        DB::table('lugares')->insert($lugares);
    }
}