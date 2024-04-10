<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Valor;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
    public function add($id_cuadro)
    {

        $valoracion = "";
        $cuadro = \App\Models\Cuadro::find($id_cuadro);

        switch ($cuadro->valoracion) {
            case 1:
                $valoracion = "Pésimo";
                break;
            case 2:
                $valoracion = "Aceptable";
                break;
            case 3:
                $valoracion = "Se lo ha ganao";
                break;
            case 4:
                $valoracion = "Atrevido";
                break;
            case 5:
                $valoracion = "Magnífico";
                break;
        }

        $valoreurodolar = Valor::first();
        $numero_sin_comas = str_replace(',', '', number_format($cuadro->precio * $valoreurodolar->valored, 2));
        $qrDirection = "http://localhost/proyectos/galeryApp/public/mostrar/" . $cuadro->id . "/EUR/$cuadro->id";
        $itemList = [
            'attrCategory' => "practicas",
            'attrName' => "sergioromero",
            'barCode' => 'lechuga',
            'qrCode' => $qrDirection,
            'custFeature1' => $cuadro->nombre,
            'custFeature2' => $cuadro->autor,

            'custFeature3' => $qrDirection,
            'custFeature4' => $cuadro->ubicacion,
            'custFeature5' => $valoracion,
            'custFeature6' => $cuadro->valoracion,

            'price' =>  $numero_sin_comas,



        ];
        $api = new \App\Services\APIService();
        $tokenSucio = $api->loginCloud();
        $token = reset($tokenSucio);
        if ($api->isTokenValid($token)) {
            $data = [
                'agencyId' => $tokenSucio['agencyId'],
                'merchantId' => $tokenSucio['merchantId'],
                'itemList' => [$itemList]
            ];
            dd($api->batchImportItem($itemList));
        }
    }

    public function bind($id_cuadro)
    {

        /* $itemInfo = [
            'eslBarcode' => "804466072",
            'itemBarcode' => "lechuga",
        ];
        $data = [
            'storeId' => "1703841945006",
            'tagItemBinds' => [$itemInfo],
        ]; */

        $api = new \App\Services\APIService();
        $api->batchBind("804466072", "lechuga");
    }

    public function uploadCuadroImagen($id_cuadro)
    {
        $cuadro = \App\Models\Cuadro::find($id_cuadro);
        $api = new \App\Services\APIService();
        
        if (!$cuadro) {
            return response()->json(['error' => 'El cuadro no existe'], 404);
        }

        $cuadro->imagen = public_path($cuadro->imagen);
        // Verificar si la imagen del cuadro existe
        if (!file_exists($cuadro->imagen)) {
            return response()->json(['error' => 'La imagen del cuadro no existe'], 404);
        }

        // Obtención del nombre de archivo y tipo de contenido
        $fileName = basename($cuadro->imagen);
        $mimeType = mime_content_type($cuadro->imagen);

        // Conexión con la API de las etiquetas
        // Creación de los datos para la solicitud POST
        $nuevoString = str_replace('\\', '/', $cuadro->imagen);
        $data = [
            'multipartFile' => curl_file_create($nuevoString, $mimeType, $fileName)
        ];
        // Parámetros de la solicitud
        $query = [
            'Authorization' => $api->getToken(),
            'attrCategory' => "practicas",
            'attrName' => "sergioromero",
            'barCode' => 'lechuga',
            'custFeature1' => $cuadro->nombre,
            'custFeature2' => $cuadro->autor,
            'qrCode' => "http://localhost/proyectos/galeryApp/public/mostrar/" . $cuadro->id . "/EUR/" . $cuadro->id,
            'merchantId' => $api->loginCloud()['merchantId'],
            'picNum' => 1,
            'storeId' => "1703841945006",
        ];

        // Realizar la solicitud POST
        $response = $api->makeRequest('IMAGE', "/itemPic/uploadItemPic?" . http_build_query($query), $data, $api->loginCloud()['token']);

        // Decodificar la respuesta JSON
        $response = json_decode($response, true);
        dd($response);
        // Retornar la respuesta
        return response()->json($response);
    }
}
