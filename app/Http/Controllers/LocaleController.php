<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        $availableLocales = ['en', 'ku'];
        
        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        
        return redirect()->back();
    }
}