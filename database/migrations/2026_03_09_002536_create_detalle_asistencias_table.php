<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('detalle_asistencia', function (Blueprint $table) {
        $table->id('id_detalle');
        
        // Esta línea es la clave: debe apuntar a id_asesoria
        $table->unsignedBigInteger('id_as');
        $table->foreign('id_as')->references('id_asesoria')->on('asesorias')->onDelete('cascade');

        $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
        $table->boolean('asistio')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_asistencias');
    }
};
