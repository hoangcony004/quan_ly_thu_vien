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
        Schema::create('dong_phat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maMuon')->constrained('muon_sach');
            $table->decimal('soTienPhat', 10, 2);
            $table->enum('trangThai', ['0', '1']);
            $table->date('ngayPhat');
            $table->string('moTa');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dong_phat');
    }
};