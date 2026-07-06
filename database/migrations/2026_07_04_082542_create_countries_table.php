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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama negara (contoh: Germany)
            $table->string('code')->unique(); // Kode negara (contoh: DE)
            $table->string('currency')->nullable(); // Mata uang
            $table->string('region')->nullable(); // Wilayah benua
            $table->string('language')->nullable(); // Bahasa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
