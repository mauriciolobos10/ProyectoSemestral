<?php

namespace App\Repositories;

use App\Models\Egreso;
use App\Models\DetalleEgresos;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DetalleEgresoRepository
{
    public function crearDetEgreso($request)
    {     
        try {
            // $centro = CentroDistribucion::where('id', $request->egre_centro_dist)->first();
            // if($centro){
            //     throw new Exception("No existe el nombre de centro de distribucion");
            // }
            // $farmacia = Farmacia::where('id', $request->egre_farmacia_id)->first();
            // if($farmacia){
            //     throw new Exception("No existe la farmacia");
            // }
            $detEgreso = new DetalleEgresos();
            $detEgreso->id_medicamento = $request->id_medicamento;
            $detEgreso->det_egreso_id = $request->det_egreso_id;//esta mal en el modelo del profe parece
            $detEgreso->det_egr_cantidad = $request->det_egr_cantidad;
            $detEgreso->det_egr_lote = $request->det_egr_lote;
            $detEgreso->save();
            return response()->json(["detalle egreso" => $detEgreso], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminarDetEgreso($request)
    {
        try {
            $detEgreso = DetalleEgresos::find($request->id);
            if(!$detEgreso){
                throw new Exception("No existe la detalle egreso");
            }
            $detEgreso->delete();
            return response()->json(["Se ha eliminado el detalle egreso"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarDetEgreso($request)
    {
        try {

            // $stock = Stock::where('med_nombre', $request->med_nombre)->
            // where('id', '!=' ,$request->id)->first();
            // if($stock){
            //     throw new Exception("Ya existe el nombre del Stock");
            // }


            $detEgreso = DetalleEgresos::findorFail($request->id);
            isset($request->id_medicamento) && $detEgreso->id_medicamento = $request->id_medicamento;
            isset($request->det_egreso_id) && $detEgreso->det_egreso_id = $request->det_egreso_id;
            isset($request->det_egr_cantidad) && $detEgreso->det_egr_cantidad = $request->det_egr_cantidad;
            isset($request->det_egr_lote) && $detEgreso->det_egr_lote = $request->det_egr_lote;
            $detEgreso->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["egreso" => $detEgreso], Response::HTTP_OK);
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
            $detEgreso = DetalleEgresos::where('id', $request->id)->first();
            if(!$detEgreso){
                throw new Exception("No se encuentra el Detalle Egreso");
            }

        return response()->json(["egreso" => $detEgreso], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
