<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;


    //aqui no es necesario pasarle el post_id, ya que en el Modelo de Post, hemos creado una relacion con el modelo de Like
    // y ya Laravel coge por defecto el id del post
    protected $fillable = [
        'user_id'
    ];
}
