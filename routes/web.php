<?php

use App\Http\Controllers\CrudController;
use App\Http\Controllers\GaleriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GaleriaController::class, 'home'] )->name("galeria.home");

Route::get('/entrada', [GaleriaController::class, 'entrada'] )->name("galeria.entrada");

Route::get('/gestion', [GaleriaController::class, 'gestion'] )->name("galeria.gestion");

Route::post('/añadir', [CrudController::class, 'añadir'])->name("crud.añadir");

Route::get('/eliminar/{id}', [CrudController::class, 'eliminar'])->name("crud.eliminar");

Route::post('/editar', [CrudController::class, 'editar'])->name("crud.editar");

Route::get('/mostrar/{id}/{currencyState}', [GaleriaController::class, 'cuadro'])->name("galeria.mostrar");


