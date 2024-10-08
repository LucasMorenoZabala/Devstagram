<?php

namespace App\Models;

use App\Http\Controllers\LikeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //esta es la informacion que se va a llenar en la bbdd. 
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        //Esta relacion (belongsTo) es aquella que un post pertenece a un usuario, en este caso. Ademas, hace referencia al modelo de User.
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        //esta relacion significa que un post puede tener muchos comentarios
        return $this->hasMany(Comentario::class);
    }

    //aqui, como bien dije en el modelo de Like, se crea la relacion entre Like y Post, asi a la hora de dar un like
    //Laravel por defecto coge el ID del post al que le has dado like y lo rellena en la bbdd.
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        //esto lo que hace es ir automaticamente debido a la relacion y al modelo que tenemos y ese modelo esta asociado a la migracion 
        //y al controlador, se situa en likes(tabla de bbdd) y ese contains revisa cualquiera de las columnas de esa tabla
        return $this->likes->contains('user_id', $user->id);
    }
}
