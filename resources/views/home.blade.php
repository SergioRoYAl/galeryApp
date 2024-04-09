<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galery App ~WELCOME</title>
    @include('imports')
</head>
<body>
    @include('navbar')
<div class="container container-principal">
    <div class="d-flex">

        <div class="containerIzq">

                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="{{asset("../resources/img/art.jpg")}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="{{asset("../resources/img/art.jpg")}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="{{asset("../resources/img/art.jpg")}}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>

        </div>
        <div class="ms-5 mt-5">
        <h1>Galery</h1>
        <h5>Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. <br>
            Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, <br>
             cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó <br> 
             una galería de textos y los mezcló de tal manera que logró hacer un libro de textos <br>
             especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno <br>
             en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado <br>
              en brlos 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de <br>
              Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus <br>
              PageMaker, el cual incluye versiones de Lorem Ipsum.</h5>
        </div>
        
        
    </div>
</div>
    
</body>
</html>