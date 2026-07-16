<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        session()->put('locale', $locale);

        session()->save();

        dd(session()->all());
    }
}