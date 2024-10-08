<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{


    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {


        /*simplemente llamas una clase integrada de laravel para crear reglas llamada Rule, llamas al método estático unique y le integras como argumentos el nombre de la tabla y el campo del valor que deseas excluir, ya luego concatenas el método ignore y le incluyes el registro a través del método o variable correspondiente dependiendo del caso.*/
        $request->validate([
            // 'username' => 'required|unique:users|min:3|max:20'
            'username' => [
                'required',

                //con esto lo que haces es que no puedas ponerte el usuario de uno ya existente
                //y que si tu estas en tu perfil y le das a guardar cambios con el mismo nombre, te deje cambiarlo, gracias al ignore
                Rule::unique('users', 'username')->ignore(Auth::user()),
                'min:3',
                'max:20',
                //not_in lo que hace es que no te deja ponerte estos nombres
                'not_in:twitter,editar-perfil,instagram'
            ]
        ]);

        if ($request->imagen) {
            $manager = new ImageManager(new Driver());

            $imagen = $request->file('imagen');

            //generar un id unico para las imagenes
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            //guardar la imagen al servidor
            $imagenServidor = $manager->read($imagen);
            //agregamos efecto a la imagen con intervention
            $imagenServidor->scale(1000, 1000);
            // la unidad de mide en PX 1= 1pixiel

            //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
            $imagenesPath = public_path('perfiles') . '/' . $nombreImagen;
            //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
            $imagenServidor->save($imagenesPath);
        }

        //guardar cambios
        //aqui el find() lo que hace es buscar al usuario actual por su ID
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;
        $usuario->save();

        //redireccionar
        //aqui cogemos el usuario de la ultima variable, en caso de que hayan cambiado el nombre de usuario.
        return redirect()->route('posts.index', $usuario->username);
    }
}
