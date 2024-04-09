<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GALERIA: GESTION</title>
    @include('imports')
    <script async  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbfu-vRu7k7naT-Fh_457upAICHgZW1UI&callback=initAutocomplete&libraries=places&v=weekly"></script>
    </head>
<style>
    .pac-container {
        z-index: 9999; /* Cambia este valor según sea necesario */
    }
</style>
<body>
    @include('navbar')

    <div class="container">

        <div class="modal" id="myNewForm">
            <div class="modal-dialog">
              <div class="modal-content">
          
                <!-- Modal Header -->
                <div class="modal-header">
                  <h1>Añadir un nuevo cuadro</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ route("crud.añadir") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-2">
                            <label for="nombreInput">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombreInput" aria-describedby="modeloHelp" placeholder="Ingrese el nombre">
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="autorInput">Autor</label>
                            <input type="text" name="autor" class="form-control" id="autorInput" placeholder="Ingrese el autor">
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="descripcionInput">Descripcion</label>
                            <input type="text" name="descripcion" class="form-control" id="descripcionInput" placeholder="Ingrese la descripción">
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="precioInput">Precio</label>
                            <input type="text" name="precio" class="form-control" id="precioInput" placeholder="Ingrese el precio">
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="ubicacionInput">Ubicacion</label>
                            <input id="autocomplete" type="text" name="ubicacion" class="form-control"  placeholder="Ingrese la ubicacion">
                     
                        </div>
                        
                        <div class="form-group mt-2 mb-3">
                            <label for="imagenInput">Imagen</label>
                            <input type="file" name="imagen" class="form-control-file" id="imagenInput">
                        </div>
                    
                        <div class="mt-2">
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                        </div>
                    </form>
                    
                </div>
               
          
              </div>
            </div>
          </div>

          <!-- FORMULARIO DE EDITAJE -->
          <div class="modal" id="myEditForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h1>Editar Cuadro</h1>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route("crud.editar")}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Campos del formulario de edición -->
                            <div class="form-group mt-2">
                                <input type="hidden" name="idd" id="cuadroIdEditar" readonly>
                            </div>
                           
                            <div class="form-group mt-2">
                                <label for="nombreInputEditar">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="nombreInputEditar" aria-describedby="modeloHelp" placeholder="Ingrese el nombre">
                            </div>
                            <div class="form-group mt-2">
                                <label for="autorInputEditar">Autor</label>
                                <input type="text" name="autor" class="form-control" id="autorInputEditar" placeholder="Ingrese el autor">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="descripcionInputEditar">Descripcion</label>
                                <input type="text" name="descripcion" class="form-control" id="descripcionInputEditar" placeholder="Ingrese la descripción">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="precioInputEditar">Precio</label>
                                <input type="text" name="precio" class="form-control" id="precioInputEditar" placeholder="Ingrese el precio">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="ubicacionInputEditar">Ubicacion</label>
                                <input type="text" name="ubicacion" class="form-control" id="ubicacionInputEditar" placeholder="Ingrese la ubicacion">
                            </div>
                            
                            <div class="form-group mt-2 mb-3">
                                <label for="imagenInputEditar">Imagen</label>
                                <input type="file" name="imagen" class="form-control-file" id="imagenInputEditar">
                            </div>
                            <div class="mt-2">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex mt-3">
            <div>
                <div class="row">
                    <div class="col-3">
                        <h3 class="h3">Listado de cuadros</h3>
                        

                    </div>
                    <div class="col-8">
                        @if(session("Correcto") || session("Error"))
                        <div >
                            <h5 class="h5" style="color: green; background-color: lightgreen; border-radius: 5px; text-align: center">{{session("Correcto")}}</h5>
                            <h5 class="h5" style="color: red; background-color: lightcoral; border-radius: 5px; text-align: center">{{session("Error")}}</h5>
                        </div>
                         
                        @endif
                        
                    </div>
                    <div class="col-1">

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myNewForm"><i class="fa-solid fa-plus"></i></button>
                    </div>
                   
                    
                </div>
               
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Autor</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Ubicacion</th>
                            <th>Imagen</th>
                            <th>QR</th>
                            <th>Valoración</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuadros as $cuadro)
                        <tr>
                            <td>{{$cuadro->id}}</td>
                            <td>{{$cuadro->nombre}}</td>
                            <td>{{$cuadro->autor}}</td>
                            <td style="max-width: 200px;">{{ Str::limit($cuadro->descripcion, 50) }}</td>
                            <td>{{$cuadro->precio}}€</td>
                            <td style="max-width: 130px">{{$cuadro->ubicacion}}</td>
                            <td style="max-width: 180px">
                                <img src="{{asset($cuadro->imagen)}}" alt="Imagen del producto" width="100" height="80">
                                <br>
                                {{Str::limit($cuadro->imagen, 15)}}</td>
                            <td>{{$cuadro->qr}}</td>
                            <td>{{$cuadro->valoracion}}</td>
                            <td class="flex-row ">
                                <button class="btn btn-warning editar" 
                                    data-idd="{{ $cuadro->id }}" 
                                    data-nombre="{{ $cuadro->nombre }}" 
                                    data-autor="{{ $cuadro->autor }}"
                                    data-descripcion="{{ $cuadro->descripcion }}"
                                    data-precio="{{ $cuadro->precio }}"
                                    data-ubicacion="{{ $cuadro->ubicacion }}" 
                                    data-imagen="{{ $cuadro->imagen}}"
                                    
                                    data-bs-toggle="modal" data-bs-target="#myEditForm">
                                <i class="fa-solid fa-pen-nib"></i>
                            </button>
                                <a href="{{route("crud.eliminar", $cuadro["id"])}}" onclick="return res()"><button src="" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button></a>
                                
                                <button class="btn btn-success"><i class="fa-solid fa-file-image"></i></button>
                                <a id="gallery-link" href="{{ route('galeria.mostrar', ['id' => $cuadro->id, 'currencyState' => 'EUR', 'valoraciones' => $cuadro->id])}}">
  <i class="fa-regular fa-eye"></i>
</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                   
            </div>
        </div>
    </div>
</body>

<script>
    

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener todos los botones de edición
        const botonesEditar = document.querySelectorAll('.editar');

        // Agregar evento click a cada botón de edición
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function() {
                // Obtener los datos del cuadro del atributo data-* del botón de edición
                const idd = boton.getAttribute('data-idd');
                const nombre = boton.getAttribute('data-nombre');
                const autor = boton.getAttribute('data-autor');
                const descripcion = boton.getAttribute('data-descripcion');
                const precio = boton.getAttribute('data-precio');
                const ubicacion = boton.getAttribute('data-ubicacion');
                const imagen = boton.getAttribute('data-imagen');
                

                // Rellenar los campos del formulario de edición con los datos del cuadro
                document.getElementById('nombreInputEditar').value = nombre;
                document.getElementById('autorInputEditar').value = autor;
                document.getElementById('descripcionInputEditar').value = descripcion;
                document.getElementById('precioInputEditar').value = precio;
                document.getElementById('ubicacionInputEditar').value = ubicacion;
                document.getElementById('cuadroIdEditar').value = idd;
                // Mostrar el modal de edición
                const modalEditar = new bootstrap.Modal(document.getElementById('myEditForm'));
                modalEditar.show();
            });
        });
    });

    var res=function(){
    var not=confirm("¿Estás seguro de que quieres eliminar el modelo?");
    return not;
  }
  let autocomplete;
  let autocomplete2;
  function initAutocomplete(){
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('autocomplete'),
                {
                    types: ['establishment'],
                    componentRestrictions: {'country' : ['ES']},
                    fields: ['place_id', 'geometry','name']
                },
                autocomplete2 = new google.maps.places.Autocomplete(
                document.getElementById('ubicacionInputEditar'),
                {
                    types: ['establishment'],
                    componentRestrictions: {'country' : ['ES']},
                    fields: ['place_id', 'geometry','name']
                },
            
                )    
        )};
    
    
    
    
  </script>
</html>