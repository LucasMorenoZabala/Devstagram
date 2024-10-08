<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class HomeController extends Controller
{

    public function __invoke()
    {
        //obtener a quien seguimos

        //pluck nos trae solo el campo de base de datos que nosotros le metemos por parametro
        $ids = Auth::user()->following->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);


        return view('home', [
            'posts' => $posts
        ]);
    }
}
