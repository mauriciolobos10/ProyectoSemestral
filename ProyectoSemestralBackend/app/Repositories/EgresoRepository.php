<?php

namespace App\Repositories;

use App\Models\Egreso;
use App\Models\Farmacia;
use App\Models\CentroDistribucion;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EgresoRepository
{
    public function crearEgreso($request)
    {     
        try {
            $centro = CentroDistribucion::where('id', $request->egre_centro_dist)->first();
            if($centro){
                throw new Exception("No existe el nombre de centro de distribucion");
            }
            $farmacia = Farmacia::where('id', $request->egre_farmacia_id)->first();
            if($farmacia){
                throw new Exception("No existe la farmacia");
            }
            $egreso = new Egreso();
            $egreso->egre_centro_dist = $request->egre_centro_dist;
            $egreso->egre_farmacia_id = $request->egre_farmacia_id;
            $egreso->egre_fecha = $request->egre_fecha;
            $egreso->save();
            return response()->json(["egreso" => $egreso], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminarEgreso($request)
    {
        try {
            $egreso = Egreso::find($request->id);
            if(!$egreso){
                throw new Exception("No existe la farmacia");
            }
            $egreso->delete();
            return response()->json(["Se ha eliminado el egreso"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarEgreso($request)
    {
        try {

            // $stock = Stock::where('med_nombre', $request->med_nombre)->
            // where('id', '!=' ,$request->id)->first();
            // if($stock){
            //     throw new Exception("Ya existe el nombre del Stock");
            // }

            $egreso = Egreso::findorFail($request->id);
            isset($request->egre_centro_dist) && $egreso->egre_centro_dist = $request->egre_centro_dist;
            isset($request->egre_farmacia_id) && $egreso->egre_farmacia_id = $request->egre_farmacia_id;
            isset($request->egre_fecha) && $egreso->scd_id_medicamento = $request->egre_fecha;
            $egreso->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["egreso" => $egreso], Response::HTTP_OK);
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

    public function verEgreso($request)
    {
        try {
            $egreso = Egreso::where('id', $request->id)->first();
            if(!$egreso){
                throw new Exception("No se encuentra el Egreso");
            }

        return response()->json(["egreso" => $egreso], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
