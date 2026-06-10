<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        return view('parts.index');
    }

    public function show($id)
    {
        return view('parts.show');
    }
}