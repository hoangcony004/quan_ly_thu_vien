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
        Schema::create('sach', function (Blueprint $table) {
            $table->id();
            $table->string('maSach')->unique();
            $table->foreignId('maTacGia')->constrained('tac_gia');
            $table->foreignId('maTheLoai')->constrained('the_loai');
            $table->foreignId('maNhaXuatBan')->constrained('nha_xuat_ban');
            $table->string('tenSach');
            $table->date('ngayXuatBan');
            $table->integer('soLuong');
            $table->string('moTa');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sach');
    }
};
