<?php

use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\ValoracionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GaleriaController::class, 'home'] )->name("galeria.home");

Route::get('/entrada', [GaleriaController::class, 'entrada'] )->name("galeria.entrada");

Route::get('/gestion', [GaleriaController::class, 'gestion'] )->name("galeria.gestion");

Route::post('/añadir', [CrudController::class, 'añadir'])->name("crud.añadir");

Route::get('/eliminar/{id}', [CrudController::class, 'eliminar'])->name("crud.eliminar");

Route::post('/editar', [CrudController::class, 'editar'])->name("crud.editar");

Route::get('/mostrar/{id}/{currencyState}/{valoraciones}', [GaleriaController::class, 'cuadro'])->name("galeria.mostrar");

Route::get('/valorar/{id_cuadro}/{valor}', [ValoracionController::class, 'valorar'])->name("crud.valorar");

Route::get('/loginAPI/{id_cuadro}', [ApiServiceController::class, 'add'])->name("login.api");

Route::get('/imagenEtiqueta/{id_cuadro}', [ApiServiceController::class, 'uploadCuadroImagen'])->name("cargar.ci");
