<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valor extends Model
{
    use HasFactory;

    public $table = "valoreurodolar";
    public $timestamps = false;

    protected $fillable = [
        'valored'
    ];
}
