@extends('layouts.app')


@section('titulo')
    Editar perfil: {{ Auth::user()->username }}
@endsection


@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{ route('perfil.store') }}" method="POST" class="mt-10 md:mt-0" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre de usuario
                    </label>

                    <input type="text" id="username" name="username" placeholder="Tu nombre de usuario..."
                        class="border p-3 w-full rounded-lg @error('username')border-red-500 @enderror"
                        value="{{ Auth::user()->username }}" />

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen del perfil
                    </label>

                    <input type="file" id="imagen" name="imagen" class="border p-3 w-full rounded-lg "
                        accept=".jpg, .jpeg, .png" />
                </div>


                <input type="submit" value="Guardar cambios"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 rounded-lg text-white " />
            </form>
        </div>
    </div>
@endsection
