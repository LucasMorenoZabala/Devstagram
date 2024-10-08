<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;

Route::get('/', HomeController::class)->name('home')->middleware('auth');


Route::get('/register', [RegisterController::class, 'index'])->name('register');
//Para tener una misma URL y dos métodos distintos, tenemos que hacer lo que hay aquí. 
//Misma URL, mismo controlador pero distinta función. La cuál tiene dentro un mensaje cuando sea POST
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index')->middleware('auth');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store')->middleware('auth');



//asi se hace para que en la URL tenga el nombre de usuario de la persona
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

//esta ruta (create) es una ruta ya predefinida de Laravel. Primero le pones la pagina donde quieres crear algo
// y con el CREATE ya lo hace.
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
//la funcionalidad SHOW es nativa de laravel, por lo que tendremos que llamar asi a nuestra funcion para que nos muestre la imagen 
//que estemos clicando.
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');


Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

//Siguiendo a usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');
