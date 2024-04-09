<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$cuadro->nombre}}</title>
    @include('imports')
    <script async  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbfu-vRu7k7naT-Fh_457upAICHgZW1UI&callback=iniciarMap&libraries=places&v=weekly"></script>
</head>
<body>
    @include('navbar')
    <div class="container">
        <div class="d-flex flex-row ">
            <div class="col-6 mt-4 ">
                <h1>{{$cuadro->nombre}}</h1>
                <img src="{{asset($cuadro->imagen)}}" alt="Visualizacion del cuadro" height="56%" width="84%">
                <div class="mt-3" role="group" aria-label="Currency Selector">
            ( <a href="{{route('galeria.mostrar', ['id' => $cuadro->id, 'currencyState' => "EUR", 'valoraciones' => '0'])}}"><i class="fa-solid fa-euro-sign">EUR</i></a>
                or
                <a href="{{route('galeria.mostrar', ['id' => $cuadro->id, 'currencyState' => "USD", 'valoraciones' => '0'])}}"><i class="fa-solid fa-dollar-sign">USD</i></a>
            )
                </div>
                <h3>{{$cuadro->precio}} {{$currencyState}}</h3>

                <p>{{$cuadro->descripcion}}</p>

                <br>

                <div class="valoracion d-flex flex-row align-items-center ">
                @if(session("Perfecto"))
                        <div >
                            <h5 class="h5" style="color: green; background-color: lightgreen; border-radius: 5px; text-align: center">{{session("Perfecto")}}</h5>
                        </div>
                         
                        @endif
                    <h2 class="me-3">Desea valorar el cuadro?</h2>
                    <div class="flex-column">
                        <a href="{{route('crud.valorar', ['id_cuadro' => $cuadro->id, 'valor' => "1"])}}"><span class="fa-solid fa-star"></span></a>
                        <a href="{{route('crud.valorar', ['id_cuadro' => $cuadro->id, 'valor' => "2"])}}"><span class="fa-solid fa-star"></span></a>
                        <a href="{{route('crud.valorar', ['id_cuadro' => $cuadro->id, 'valor' => "3"])}}"><span class="fa-solid fa-star"></span></a>
                        <a href="{{route('crud.valorar', ['id_cuadro' => $cuadro->id, 'valor' => "4"])}}"><span class="fa-solid fa-star"></span></a>
                        <a href="{{route('crud.valorar', ['id_cuadro' => $cuadro->id, 'valor' => "5"])}}"><span class="fa-solid fa-star"></span></a>
                        <h5>La media del cuadro es {{$cuadro->valoracion}} ({{$valoraciones}}) </h5>
                    </div>
                    
                </div>
            </div>
            <div class="col-6 mt-4">
                <h3>>Ubicación:<br></h3>
            <h4> {{$cuadro->ubicacion}}</h4>
                
                <div id="map" style="height: 500px; width: 100%"> </div>
            </div>
        </div>
        
        
    </div>
    

    <script>


        function iniciarMap(){
            var geocoder = new google.maps.Geocoder();
            var address = "<?php echo $cuadro->ubicacion; ?>";

            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    var coord = {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng()
                    };
                    var map = new google.maps.Map(document.getElementById('map'),{
                        zoom: 21,
                        center: coord,
                    })

                } else {
                    console.error('Geocoding failed: ' + status);
                }
            })

           
        }           
    </script>
</body>
</html>
