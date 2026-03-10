<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('asesorias', function (Blueprint $table) {
        $table->id('id_asesoria');
        $table->foreignId('id_experto')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_alumno')->nullable()->constrained('users')->onDelete('cascade');
        $table->unsignedBigInteger('id_lugar')->nullable();
        $table->foreign('id_lugar')->references('id_lugar')->on('lugares')->onDelete('set null');
        $table->string('materia');
        $table->date('fecha');
        $table->time('hora_ini');
        $table->time('hora_fin');
        $table->text('descripcion')->nullable();
        $table->string('estado')->default('Disponible'); 
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('asesorias');
    }
};