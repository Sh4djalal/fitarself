<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'ku'])) {
            session(['locale' => $locale]);
            App::setLocale($locale);
        }

        return back();
    }
}