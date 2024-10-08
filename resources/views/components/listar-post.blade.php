<div>

    {{-- este slot hace referencia a home.blade. Es como un placeholder donde vas a escribir tu codigo 
    <h1>{{ $slot }}</h1>
    --}}


    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            {{-- Con este ForEach lo que haces es recorrer todas las publicaciones que ese usuario tenga en la bbdd y las muestras. --}}
            @foreach ($posts as $post)
                <div>
                    {{-- para que al clicar en la foto, detecte que foto estas clicando, tienes que pasarle al metodo ROUTE, 
            la variable $post que es la que estas metiendo en WEB.php --}}
                    <a href="{{ route('posts.show', ['user' => $post->user, 'post' => $post]) }}">
                        {{-- Si solo ponemos $post->imagen, no nos va a mostar las imagenes, 
             ya que ahi solo estan almacenadas las rutas de las imagenes, no la imagen en si.
             Para que se muestren las imagenes, tienes que concatenarle la ruta donde tengas guardas tu esas fotos. --}}
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-center">No hay posts, sigue a alguien que tenga publicaciones para poder ver sus publicaciones.
        </p>
    @endif

</div>
