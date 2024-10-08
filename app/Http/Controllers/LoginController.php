<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //La funcion back() sirve para que cuando envies mal el formulario de login, vuelva a la pagina donde habias enviado esos datos
        //y el with(), tiene la variable mensaje, que asi es como lo vas a llamar en login.blade
        // y el mensaje que quieres que se muestre
        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        return redirect()->route('posts.index', ['user' => $request->user()->username]);
    }
}
