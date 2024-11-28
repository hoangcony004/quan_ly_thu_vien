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
        Schema::create('muon_sach', function (Blueprint $table) {
            $table->id();
            $table->string('maMuonSach')->unique();
            $table->string('tenNguoiMuon');
            $table->integer('soLuong');
            $table->date('ngayMuon');
            $table->date('ngayTra')->nullable();
            $table->enum('trangThai', ['1', '2', '3', '4', '5']);
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muon_sach');
    }
};