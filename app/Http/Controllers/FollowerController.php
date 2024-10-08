<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    //funcionalidad para seguir a una persona
    public function store(User $user)
    {
        //este USER va a ser la persona que estamos SIGUIENDO

        $user->followers()->attach(Auth::user()->id);

        return back();
    }

    //funcionalidad para dejar de seguir a una persona
    public function destroy(User $user)
    {
        $user->followers()->detach(Auth::user()->id);

        return back();
    }
}
