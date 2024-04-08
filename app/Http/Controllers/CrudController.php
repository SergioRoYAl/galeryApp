<?php

namespace App\Http\Controllers;

use App\Models\Cuadro;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function añadir(Request $request){

        $pathDeImagen = "";
        $request->validate([
            'nombre' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            // Obtiene el nombre original del archivo
            $imageName = $request->file('imagen')->getClientOriginalName();
            // Mueve el archivo a una ubicación permanente (ejemplo: carpeta public/images)
            $request->file('imagen')->move(public_path('images'), $imageName);
            // Retorna la ruta de la imagen guardada
            $imagePath = 'images/' . $imageName;
            $pathDeImagen = $imagePath;
        } else {
            back()->with("Error", " pero no se ha podido cargar la imagen");
        }
        
        $cuadroExiste=Cuadro::where("nombre", $request->nombre)->exists();

        if($cuadroExiste){
            return back()->with("Error" , "El nombre del cuadro ya existe");
        } else {
            $cuadroNuevo=Cuadro::create([
                'nombre' => $request->nombre,
                'autor' => $request->autor,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'ubicacion' => $request->ubicacion,
                'imagen' => $pathDeImagen,
                'qr' => $request->qr,
                'valoracion' => $request->valoracion
            ]);

            if($cuadroNuevo){
                return back()->with('Correcto', 'Se ha añadido con exito el cuadro');
            } else {
                return back()->with('Error', 'Comprueba que los parametros estén correctos');
            }
        }
    }

    public function uploadFoto(Request $request){
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas de validación según tus necesidades
        ]);

        if ($request->hasFile('imagen')) {
            // Obtiene el nombre original del archivo
            $imageName = $request->file('imagen')->getClientOriginalName();
            // Mueve el archivo a una ubicación permanente (ejemplo: carpeta public/images)
            $request->file('imagen')->move(public_path('images'), $imageName);
            // Retorna la ruta de la imagen guardada
            $imagePath = 'images/' . $imageName;
            return $imagePath;
        }

        // Retorna algo si la carga falla
        return 'Error al cargar la imagen.';
    }

    public function eliminar($idABorrar){
        $sql=Cuadro::where("id", $idABorrar)->delete();
        if($sql){
            return back()->with("Correcto", "Se ha eliminado correctamente el cuadro");
        } else {
            return back()->with("Error", "No se ha podido eliminar el cuadro, no existe");
        }
    }

    public function editar(Request $request) {
        // Obtener el cuadro a editar por su ID
        $cuadro = Cuadro::find($request->idd); // Utiliza find() para obtener el modelo por su ID
    
        if (!$cuadro) {
            // Manejar el caso en que el cuadro no se encuentre
            return back()->with("Error", "No se encontró el cuadro a editar");
        }
    
        // Actualizar los datos del cuadro con los datos del formulario de edición
        $cuadro->nombre = $request->nombre;
        $cuadro->autor = $request->autor;
        $cuadro->descripcion = $request->descripcion;
        $cuadro->precio = $request->precio;
        $cuadro->ubicacion = $request->ubicacion;
    
        // Guardar la imagen solo si se proporciona una nueva
        if ($request->hasFile('imagen')) {
            $imagePath = $this->uploadFoto($request); // Reutiliza la función para cargar la imagen
            $cuadro->imagen = $imagePath;
        }
    
        // Guardar los cambios en la base de datos
        $cuadro->save();
    
        // Redirigir o responder según sea necesario
        return back()->with("Correcto", "Se ha editado correctamente el cuadro");
    }
    

}
