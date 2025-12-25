<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonAn;
use App\Models\DonHang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
         
        return view('admin.dashboard');
    }
}