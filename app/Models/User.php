<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /*esta variable $fillable, es lo que nuestra APP espera que rellene el usuario para introducir en la bbdd.
    en este caso, no estaba añadido el username y nos daba fallo a la hora de crear un usuario, por lo que hemos tenido que añadirlo.
    */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    //Redireccionar

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        //Esta es la relacion Has to Many pero se escribe asi. Esta relacion significa que un usuario puede tener multiples posts. 
        //Ademas, hace relación al modelo de Post, ya que es lo que estamos relacionando.
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Almacenar los seguidores de un usuario

    //aqui soy el user_id
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Almacenar los seguidos mios
    //aqui soy el follower_id
    //la unica diferencia entre FOLLOWERS y FOLLOWING, es el orden de las columnas user_id y follower_id. Depende de cual vaya primero
    //es para seguidores o seguidos
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }


    //Comprobar si un usuario ya sigue a un usuario
    public function comprobarSiguiendo(User $user)
    {
        //esto va a llamar a la funcion followers y el contains va a comprobar si somos seguidores de esa persona o no
        //Este usuario es el que sigue al otro
        return $this->followers->contains($user->id);
    }
}
