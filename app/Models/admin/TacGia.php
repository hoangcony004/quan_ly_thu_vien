<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacGia extends Model
{
    use HasFactory;

    protected $table = 'tac_gia';

    protected $fillable = ['tenTacGia', 'ngaySinh', 'ngayMat', 'trangThai',  'moTa', 'created_at', 'updated_at'];

    public $timestamps = false;
}
