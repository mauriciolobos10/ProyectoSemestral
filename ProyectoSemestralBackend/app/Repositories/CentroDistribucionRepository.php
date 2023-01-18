<?php

namespace App\Repositories;

use App\Models\CentroDistribucion;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CentroDistribucionRepository
{
    public function crearCentro($request)
    {     
        try {
            // $centro = Farmacia::where('farm_nombre', $request->farm_nombre)->first();
            // if($centro){
            //     throw new Exception("Ya existe el nombre de farmacia");
            // }
            $centro = new CentroDistribucion();
            $centro->cd_codigo = $request->cd_codigo;
            $centro->cd_direccion = $request->cd_direccion;
            $centro->cd_telefono = $request->cd_telefono;
            $centro->save();
            return response()->json(["centro" => $centro], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminarCentro($request)
    {
        try {
            $centro = CentroDistribucion::find($request->id);
            if(!$centro){
                throw new Exception("no existe el centro");
            }
            $centro->delete();
            return response()->json(["Se ha eliminado el centro"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarCentro($request)
    {
        try {

            // $centro = CentroDistribucion::where('cd_codigo', $request->cd_codigo)->
            // where('id', '!=' ,$request->id)->first();
            // if($centro){
            //     throw new Exception("Ya existe el nombre de farmacia");
            // }
            
            $centro = CentroDistribucion::findorFail($request->id);
            isset($request->cd_codigo) && $centro->cd_codigo = $request->cd_codigo;
            isset($request->cd_direccion) && $centro->cd_direccion = $request->cd_direccion;
            isset($request->cd_telefono) && $centro->cd_telefono = $request->cd_telefono;
            $centro->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["Centro" => $centro], Response::HTTP_OK);
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

    public function verCentro($request)
    {
        try {
            $centro = CentroDistribucion::where('id', $request->id)->first();
            if(!$centro){
                throw new Exception("No se encuentra centro");
            }

        return response()->json(["centro" => $centro], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verCentros(){
        try {
            $centros = CentroDistribucion::all();
            if(!$centros){
                throw new Exception("No se encontraron centros");
            }

        return response()->json(["centros" => $centros], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
