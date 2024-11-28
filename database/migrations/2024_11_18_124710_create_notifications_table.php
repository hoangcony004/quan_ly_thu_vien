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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title'); // Tiêu đề thông báo
            $table->text('content'); // Nội dung thông báo
            $table->string('type')->default('info'); // Loại thông báo (mặc định là 'info')
            $table->boolean('is_read')->default(false); // Trạng thái đã đọc
            $table->timestamp('read_at')->nullable(); // Thời gian đã đọc
            $table->string('url')->nullable(); // Link chi tiết thông báo
            $table->json('data')->nullable(); // Dữ liệu bổ sung (nếu có)
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
