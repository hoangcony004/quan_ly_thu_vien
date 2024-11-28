<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $title;

    public function index(Request $request) {}

    public function getDashboard()
    {
        // khai báo title
        $this->title = 'Admin - Dashboard';

        // chuyển hướng và truyền thông báo xuống
        return view('admin.pages.dashboard')
            ->with('title', $this->title);
    }
}