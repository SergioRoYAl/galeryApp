<?php

namespace App\Http\Controllers;

use App\Models\Cuadro;
use App\Models\Valor;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    //carga la vista de la entrada
   public function entrada() {
    return view('entrada');
   }

   //carga la vista home
   public function home() {
    return view('home');
   }

   //carga la vista de la gestion de los cuadros
   public function gestion() {
    $cuadros=Cuadro::all();
    return view('gestion', ['cuadros' => $cuadros]);
   }
//www
   public function cuadro($id, $currencyState) {
    $cuadro=Cuadro::class;
    if($currencyState=='USD'){
        $cuadro = Cuadro::find($id);
        $cuadro->precio *= Valor::first()->valored;
        return view('cuadro', ['cuadro' => $cuadro, 'currencyState' => $currencyState]);
    } else {
        $cuadro = Cuadro::find($id);
        return view('cuadro', ['cuadro' => $cuadro, 'currencyState' => $currencyState]);
    }
   }

}