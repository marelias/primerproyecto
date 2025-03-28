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
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)-> unique();
            $table->string ('title', 67);
            $table->string ('descrption', 155);
            $table->string ('nombre', 100)-> unique();
            $table->text ('descripcion');
            $table->string ('urlfoto', 100)->default("foto.jpg");
            $table->string ('visitas')->default(0);
            $table->string ('orden')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
