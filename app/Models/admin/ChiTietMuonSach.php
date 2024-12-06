<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietMuonSach extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_muon_sach';

    protected $fillable = [
        'maMuon',
        'maSach',
        'soLuong',
        'created_at',
        'updated_at'
    ];

    public function sach()
    {
        return $this->belongsTo(KhoSach::class, 'maSach');
    }

    public function muonSach()
    {
        return $this->belongsTo(MuonSach::class, 'maMuon');
    }

    public $timestamps = false;
}
