<?php

namespace App\Repositories;

use App\Models\Farmacia;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FarmaciaRepository
{
    public function crearFarmacia($request)
    {     
        try {
            $farmacia = Farmacia::where('farm_nombre', $request->farm_nombre)->first();
            if($farmacia){
                throw new Exception("Ya existe el nombre de farmacia");
            }
            $farmacia = new Farmacia();
            $farmacia->farm_nombre = $request->farm_nombre;
            $farmacia->farm_direccion = $request->farm_direccion;
            $farmacia->farm_mail = $request->farm_mail;
            $farmacia->save();
            return response()->json(["farmacia" => $farmacia], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        // $farmacia = new Farmacia();
        // $farmacia->farm_nombre = $request->farm_nombre;
        // $farmacia->farm_direccion = $request->farm_direccion;
        // $farmacia->farm_mail = $request->farm_mail;
        // $farmacia->save();

    // $libros = Libro::create([
    //     "libr_autor" => $request->autor,
    //     "libr_titulo" => $request->titulo,
    //     "genero_id" => $request->genero_id
    // ]); puede usarse cualquiera supongo, segun yo la version de arriba usa los modelos, esta no los usa

        
    }

    public function eliminarFarmacia($request)
    {
        try {
            $farmacia = Farmacia::find($request->id);
            if(!$farmacia){
                throw new Exception("PARA LOCO !!!");
            }
            $farmacia->delete();
            return response()->json(["Se ha eliminado la farmacia"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarFarmacia($request)
    {
        try {

            $farmacia = Farmacia::where('farm_nombre', $request->farm_nombre)->
            where('id', '!=' ,$request->id)->first();
            if($farmacia){
                throw new Exception("Ya existe el nombre de farmacia");
            }
            
            $farmacia = Farmacia::findorFail($request->id);
            isset($request->farm_nombre) && $farmacia->farm_nombre = $request->farm_nombre;
            isset($request->farm_direccion) && $farmacia->farm_direccion = $request->farm_direccion;
            isset($request->farm_mail) && $farmacia->farm_mail = $request->farm_mail;
            $farmacia->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["Farmacia" => $farmacia], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::info([
                "error" => $e,
                "mensaje" => $e->getMessage(),
                "linea" => $e->getLine(),
                "archivo" => $e->getFile(),
            ]);
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verFarmacia($request)
    {
        try {
            $farmacia = Farmacia::where('id', $request->id)->first();
            if(!$farmacia){
                throw new Exception("No se encuentra la farmacia");
            }

        return response()->json(["farmacia" => $farmacia], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    //aaa
    // public function listarLibros()
    // {
    //     $libros = Libro::all();
    //     $generos = Genero::all();
    //     return response()->json(["libros" => $libros, "generos" => $generos], Response::HTTP_OK);
    // }
    // public function filtrarLibros($request)
    // {

    //     $libros = Libro::where('id', $request->id)->with(['genero', 'comentario'])
    //         ->get();

    //     return response()->json(
    //         ["libros" => $libros],
    //         Response::HTTP_OK
    //     );
    // }

    // public function guardarLibros($request)
    // {
    //     //$libros = new Libro();
    //     //$libros->libr_autor = $request->autor;
    //     //$libros->libr_titulo = $request->titulo;
    //     //$libros->genero_id = $request->genero_id;
    //     //$libros->save();

    //     $libros = Libro::create([
    //         "libr_autor" => $request->autor,
    //         "libr_titulo" => $request->titulo,
    //         "genero_id" => $request->genero_id
    //     ]);

    //     return response()->json(["libros" => $libros], Response::HTTP_OK);
    // }

    // public function actualizarLibro($request)
    // {
    //     try {
    //         $libros = Libro::findorFail($request->id);
    //         isset($request->titulo) && $libros->libr_titulo = $request->titulo;
    //         isset($request->genero) && $libros->genero_id = $request->genero;
    //         $libros->save();

    //         $libros = Libro::where('id', $request->id)
    //             ->update([
    //                 'libr_titulo' => $request->titulo,
    //                 'genero_id' => $request->genero_id
    //             ]);


    //         return response()->json(["libros" => $libros], Response::HTTP_OK);
    //     } catch (Exception $e) {
    //         Log::info([
    //             "error" => $e,
    //             "mensaje" => $e->getMessage(),
    //             "linea" => $e->getLine(),
    //             "archivo" => $e->getFile(),
    //         ]);
    //         return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    //     }
    // }


    // public function eliminarLibro($request)
    // {
    //     try {
    //         $libro = Libro::find($request->id);
    //         if(!$libro){
    //             throw new Exception("PARA LOCO !!!");
    //         }
    //         $libro->delete();

    //         return response()->json(["eliminados"=>"chao"], Response::HTTP_OK);
    //     } catch (Exception $e) {
    //         return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    // public function ejemploJob($request)
    // {
    //     try {
    //         JobEjemplo::dispatch($request->all())->onQueue('ejemplo');
    //         return response()->json(["se esta ejecutando"], Response::HTTP_OK);
    //     } catch (Exception $e) {
    //         return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
    //     }
    // }


    // public function fixer(){
    //     $libros= Libro::all();
    //     foreach ($libros as $libro){
    //         $libro->libr_autor = "Nicolas Oyarce";
    //         $libro->save();
    //     }

    // }
}
