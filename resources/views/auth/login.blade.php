@extends('layouts.app')


@section('titulo')
    Inicia sesión en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen login de usuarios">
        </div>

        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-2xl">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                {{-- Así se pasa un mensaje desde el LoginController.
                --}}
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}
                    </p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>

                    <input type="email" id="email" name="email" placeholder="Tu e-mail..."
                        class="border p-3 w-full rounded-lg @error('email')border-red-500 @enderror"
                        value="{{ old('email') }}" />

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>

                    <input type="password" id="password" name="password" placeholder="Password"
                        class="border p-3 w-full rounded-lg @error('password')border-red-500 @enderror" />

                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}
                        </p>
                    @enderror
                </div>


                <div class="mb-5">
                    <input type="checkbox" name="remember"> <label class="text-gray-500 text-sm">Mantener la
                        sesión abierta</label>
                </div>



                {{-- aqui el for (id) se tiene que llamar password_confirmation, ya que laravel tiene implementado de por sí
                    una validación para confirmar la contraseña (escribirla dos veces) si pones ese nombre de clase.
                --}}

                <input type="submit" value="Iniciar sesión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 rounded-lg text-white " />
            </form>
        </div>
    </div>
@endsection
