<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LikePost extends Component
{
    //ahora ya esta disponible en la vista like-post. No es necesario enviarselo a la vista como en anteriores casos.
    public $post;
    public $isLiked;
    public $likes;

    //la funcion MOUNT() es lo mismo que un constructor en php
    /*aqui tiene la logica pero no se ve reflejado en la vista.
        Por lo que en el metodo de abajo (like) tienes que hacer el codigo reactivo a lo que estas haciendo. */
    public function mount($post)
    {
        //aqui comprobamos que, al entrar en esta vista, el usuario ha dado like o no
        $this->isLiked = $post->checkLike(Auth::user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        //se pone $this porque es la instancia a la que esta haciendo referencia en esta clase ($post, justo arriba)

        if ($this->post->checkLike(Auth::user())) {

            $this->post->likes()->where('post_id', $this->post->id)->delete();
            //asi es como al eliminar se cambia solo el corazon
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }



    public function render()
    {
        return view('livewire.like-post');
    }
}
