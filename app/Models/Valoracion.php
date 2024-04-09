<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    public $table = "valoracion";
    public $timestamps = false;

    protected $fillable = [
        'id_cuadro',
        'valor',
    ];
}
