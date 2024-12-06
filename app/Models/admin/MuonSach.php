<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuonSach extends Model
{
    use HasFactory;

    protected $table = 'muon_sach';

    protected $fillable = [
        'maMuonSach',
        'tenNguoiMuon',
        'soDienThoai',
        'email',
        'soLuong',                              
        'ngayMuon',
        'ngayTra',
        'trangThai',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function details() {
        return $this->hasMany(ChiTietMuonSach::class, 'maMuon');
    }
    
    
}
