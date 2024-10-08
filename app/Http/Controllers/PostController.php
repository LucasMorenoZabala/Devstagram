<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    //Pasandole el user por parametros, lo que hacemos es poner en la URL el nombre de usuario de la persona
    public function index(User $user)
    {
        //llamamos al modelo POST, el cual tiene asociado la tabla POSTS. Con el paginate() simplemente paginas cuantas publicaciones hay.
        //tambien existe simplePaginate() que es un estilo mas simple.
        $posts = Post::where('user_id', $user->id)->latest()->paginate(15);


        return view('dashboard', [
            //asi pasas el usuario del perfil que estas visitando
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        /* User::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $request->user()->id
        ]);*/

        //otra forma de create
        /*$post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = $request->user()->id;
        $post->save();
        */

        //asi es como se crea una publicacion con la convencion de Laravel, pero son iguales que las dos de arriba. 
        //Llamas a las relaciones que acabamos de crear (Post y User)
        //y creas la publicacion, ya sabiendo que un usuario puede tener multiples fotos pero esas fotos solo tienen un usuario.
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('posts.index', $request->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    public function authorize()
    {
        return true;
    }

    public function destroy(Post $post)
    {


        $this->authorize('delete', $post);
        $post->comentarios()->delete();
        $post->delete();
        //Eliminar la imagen
        $imagen_Path = public_path('uploads/' . $post->imagen);

        if (File::exists($imagen_Path)) {
            unlink($imagen_Path);
        }


        return redirect()->route('posts.index', Auth::user()->username);
    }
}
