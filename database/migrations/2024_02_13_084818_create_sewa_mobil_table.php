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
        Schema::create('sewa_mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('id_mobil')->constrained('master_mobils')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('no_plat');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->integer('jumlah_hari');
            $table->enum('status', ['Disewa', 'Selesai']);
            $table->integer('tarif');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_mobil');
    }
};
