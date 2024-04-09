<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cuadro;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    //
    public function valorar($id_cuadro, $valor){
        //CCada vez que se vota a un cuadro a trav'es del id y el valor del 1 al 5, se suman todas las valoraciones y se dividen por la cantidad (osea la media de las valoraciones de un cuadro en cocreto) y se modivica la media en el $cuadro->valoracion
        $cuadro = Cuadro::find($id_cuadro);
        $valoracion = new Valoracion();
        $valoracion->id_cuadro = $id_cuadro;
        $valoracion->valor = $valor;
        $valoracion->save();
        $valoraciones = Valoracion::where('id_cuadro', $id_cuadro)->get();
        $suma = 0;
        foreach($valoraciones as $valoracion){
            $suma += $valoracion->valor;
        }
        $media = $suma / count($valoraciones);
        $cuadro->valoracion = $media;
        $cuadro->save();
        return redirect()->route('galeria.mostrar', ['id' => $id_cuadro, 'currencyState' => 'EUR']);

    }

    
}
