<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request);
        //dd($request->get('username'));

        //Modificar el request
        //los una con guiones.
        //$request->$request->add(['username' => Str::slug($request->username)]);

        //Validación
        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);


        //Así se añaden datos a la base de datos a la que quieras añadir datos mediante un formulario.
        //Los nombres que pones ('name', etc) a la derecha del $request son los IDs del formulario.
        User::create([
            'name' => $request->name,
            //Str::slug es para que los usuarios que metan su username con espacios
            'username' => Str::slug($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Autenticar un usuario
        Auth::attempt($request->only('email', 'password'));


        //Redireccionar
         return redirect()->route('posts.index', ['user' => $request->user()->username]);
    }
}
