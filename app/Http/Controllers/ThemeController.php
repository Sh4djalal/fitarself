<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $current = session('theme', 'dark');
        session(['theme' => $current === 'dark' ? 'light' : 'dark']);

        return back();
    }
}