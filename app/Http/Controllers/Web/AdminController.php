<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;


class AdminController extends Controller
{

    /**
     * Вернуть представление админ-панели
     *
     * @return View ;
     */
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }
}
