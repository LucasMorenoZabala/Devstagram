<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class ComentarioController extends Controller
{
    //aqui le pasamos este user porque asi es como esta definida nuestra URL en el WEB.php. Este user es el creador de la publicacion
    //no el que esta comentando
    public function store(Request $request, User $user, Post $post)
    {
        //validar
        $request->validate([
            'comentario' => 'required|max:255'
        ]);



        //almacenar el resultado
        Comentario::create([
            //asi se cogen el id del usuario que esta comentando y el id de la foto a la que esta comentando.
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);


        //imprimir un mensaje
        //el with hace que al volver a la pagina anterior (back()), se envien datos. El with va con una session, la cual esta en show.blade.
        return back()->with('mensaje', 'Comentario enviado.');
    }
}
