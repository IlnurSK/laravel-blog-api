<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Метод отображения Админ-панели
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
