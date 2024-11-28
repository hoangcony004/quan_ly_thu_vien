<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    use HasFactory;

    protected $table = 'the_loai';

    // Khai báo các thuộc tính có thể được gán
    protected $fillable = [
        'tenTheLoai',
        'trangThai',
        'created_at', // Thêm trường này vào fillable
        'updated_at', // Thêm trường này vào fillable
    ];

    public $timestamps = false; // Tắt tính năng timestamps tự động
}
