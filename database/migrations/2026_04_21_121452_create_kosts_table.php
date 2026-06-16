<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kost');
            $table->integer('harga');
            $table->float('jarak');
            $table->enum('jenis_kost', ['putra', 'putri', 'campur']);
            $table->text('alamat');
            $table->string('no_hp');
            $table->enum('status', ['tersedia', 'penuh'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
