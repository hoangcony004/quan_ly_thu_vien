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
        Schema::create('tac_gia', function (Blueprint $table) {
            $table->id();
            $table->string('tenTacGia');
            $table->date('ngaySinh');
            $table->date('ngayMat')->nullable();
            $table->boolean('trangThai');
            $table->string('moTa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tac_gia');
    }
};
