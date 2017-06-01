<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        return view('pages.settings.index');
    }

    public function tokens() {
        if (Auth::id() != 1) {
            return redirect('/');
        }
        return view('pages.settings.tokens');
    }
}
