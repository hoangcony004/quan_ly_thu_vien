<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('chi_tiet_muon_sach', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maMuon')->constrained('muon_sach');
            $table->foreignId('maSach')->constrained('sach');
            $table->integer('soLuong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_muon_sach');
    }
};