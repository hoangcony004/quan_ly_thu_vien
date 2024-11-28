<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    use HasFactory;

    protected $table = 'sach';

    protected $fillable = [
        'maSach',
        'maTacGia',
        'maTheLoai',
        'maNhaXuatBan',
        'tenSach',
        'ngayXuatBan',
        'soLuong',
        'moTa',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function tacGia()
    {
        return $this->belongsTo(TacGia::class, 'maTacGia');
    }

    public function theLoai()
    {
        return $this->belongsTo(TheLoai::class, 'maTheLoai');
    }

    public function nhaXuatBan()
    {
        return $this->belongsTo(NhaXuatBan::class, 'maNhaXuatBan');
    }
}