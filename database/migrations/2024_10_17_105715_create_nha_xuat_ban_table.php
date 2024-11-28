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
        Schema::create('nha_xuat_ban', function (Blueprint $table) {
            $table->id();
            $table->string('tenNhaXuatBan');
            $table->string('soDienThoai')->unique();
            $table->string('email')->unique();
            $table->boolean('trangThai');
            $table->string('diaChi');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nha_xuat_ban');
    }
};