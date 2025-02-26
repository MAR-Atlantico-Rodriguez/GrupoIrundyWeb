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
        Schema::create('galerias', function (Blueprint $table) {
            $table->id();
            
            $table->string('path');
            $table->boolean('foto_principal')->default(false);
            $table->timestamps();
            //$table->foreign('id_evento')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
