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
        
        
    }

    public function eliminarFarmacia($request)
    {
        try {
            $farmacia = Farmacia::find($request->id);
            if(!$farmacia){
                throw new Exception("no existe la farmacia");
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

}
