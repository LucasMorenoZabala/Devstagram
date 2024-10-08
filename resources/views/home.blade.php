@extends('layouts.app')

{{-- Con los @section puedo hacer referencia a otra parte de otro documento, 
en este caso hacen referencia a los @yield('nombre que le hayas puesto al yield')
Y dentro de la sección, puedes escribir lo que quieras y se va a quedar
dentro de la etiqueta H1 de app.blade, ya que es el objeto que tu has nombrado 'titulo' --}}
@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- asi se llaman a los componentes en laravel 
   <x-listar-post>
         cuando tu llamas un componente con apertura y cierre
        lo que tiene dentro se llaman slots, son como espacios reservados 
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando posts desde slot</h1>
    </x-listar-post>
    --}}

    {{-- asi se pasan las variables a los componentes --}}
    <x-listar-post :posts="$posts" />


    {{-- otra manera de hacer el for each

        @forelse ($posts as $post)
            <h1>{{ $post->titulo }}</h1>
        @empty
            <p>No hay posts</p>
        @endforelse
    --}}
@endsection
