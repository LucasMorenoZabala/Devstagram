<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LogoutController extends Controller
{
    public function store()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
