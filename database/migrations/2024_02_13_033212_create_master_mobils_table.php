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
        Schema::create('master_mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merek')->constrained('master_mereks')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('id_model')->constrained('master_models')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nama');
            $table->year('tahun');
            $table->string('no_plat')->unique();
            $table->integer('tarif');
            $table->enum('status', ['Tersedia', 'Disewa', 'Tidak Tersedia']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_mobils');
    }
};
