<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
    public function add(){
        $api = new \App\Services\APIService();
        $itemList = [
            'attrCategory' => "practicas",
            'attrName' => "sergioromero",
            'barCode' => 'lechuga'
        ];
        $tokenSucio = $api->loginCloud();
        $token = reset($tokenSucio);
        if($api->isTokenValid($token)){
            $data = [
                'agencyId' => $tokenSucio['agencyId'],
                'merchantId' => $tokenSucio['merchantId'],
                'itemList' => [$itemList]
            ];
            dd($api->batchImportItem($itemList)); 
       }
    }

       public function bind(){

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
}
