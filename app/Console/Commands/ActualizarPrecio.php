<?php

namespace App\Console\Commands;

use App\Models\Valor;
use Illuminate\Console\Command;
use Laravel\Prompts\Output\ConsoleOutput;

class ActualizarPrecio extends Command
{

    protected $signature = 'actualizar:precio';
    protected $description = 'Descripción del comando aquí'; 
    public function __invoke()
    {
        
            $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.apilayer.com/currency_data/live?source=EUR&currencies=EUR%2C%20USD",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: WV9hyIi6RFOxpm1HvOf9JG6O0A8OPegI"
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        if ($response === false) {
            // Error en la solicitud cURL
            echo 'Error en la solicitud cURL: ' . curl_error($curl);
        } else {
            // Decodificar la respuesta JSON
            $decoded_response = json_decode($response, true);
            
            // Verificar si la decodificación fue exitosa y la respuesta no está vacía
            if ($decoded_response !== null && !empty($decoded_response)) {
                    
                    $eur_usd = $decoded_response['quotes']['EURUSD'];
                    
                    $valor = Valor::first();
                    if ($valor) {
                        $valor->valored = $eur_usd;
                        $valor->save();
                        $this->info('Valor actualizado correctamente.');
                    } else {
                    }
                } else {
                    
                }
        }

        
        
}  

}

