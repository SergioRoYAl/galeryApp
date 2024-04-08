<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadro extends Model
{
    use HasFactory;
    public $table = "cuadro";
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'autor',
        'precio',
        'ubicacion',
        'descripcion',
        'imagen',
        'qr',
        'valoracion'
    ];
}