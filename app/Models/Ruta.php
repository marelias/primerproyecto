<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'title',
        'descrption',
        'nombre',
        'descripcion',
        'urlfoto',
        'visitas',
        'orden'
    ];

}
