@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection


@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">

            <div class="p-3 flex items-center gap-3">
                @auth
                    {{-- asi es como se llama a un componente de livewire y a sus variables --}}
                    <livewire:like-post :post="$post" />
                @endauth

            </div>

            <div>
                <a href="{{ route('posts.index', $post->user) }}">
                    <p class="font-bold">{{ $post->user->username }}</p>
                </a>
                <p class="text-sm text-gray-500">
                    {{-- diffForHumans() este metodo lo que hace es formatear las fechas. Si tu fecha está: 2024-09-27, 
                    la pasa a: 'hace X horas/dias' --}}
                    {{ $post->created_at->diffForHumans() }}
                </p>

                <p class="mt-5">
                    {{ $post->descripcion }}
                </p>
            </div>

            {{-- asi es como manejas que solo la persona que ha creado la publicacion pueda eliminarla. --}}
            @auth
                @if ($post->user_id === Auth::user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        {{-- Esto es un METHOD SPOOFING. Quiere decir que el navegador nativamente solo soporta GET y POST 
                        y esto hace que puedas usar por ejemplo: DELETE, PATCH, ETC. --}}
                        @method('DELETE')
                        @csrf
                        <input type="submit"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold cursor-pointer mt-3"
                            value="Eliminar publicación">
                    </form>
                @endif
            @endauth
        </div>

        <div class="md:w-1/2 p-5">

            <div class="shadow bg-white p-5 mb-5">

                @auth
                    <p class="text-xl font-bold text-center mb-4">¡Escribe acerca de esta publicación!</p>

                    {{-- asi es como haces llegar el mensaje desde ComentarioController para que se muestre. Con el nombre 'mensaje' --}}
                    @if (@session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['user' => $user, 'post' => $post]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Añade un comentario
                            </label>

                            <textarea type="text" id="comentario" name="comentario" placeholder="Escribe un comentario"
                                class="border p-3 w-full rounded-lg @error('name')border-red-500 @enderror"></textarea>

                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <input type="submit" value="Comentar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 rounded-lg text-white " />
                    </form>
                @endauth


                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold">
                                    {{ $comentario->user->username }}
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay ningún comentario que mostrar...</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
