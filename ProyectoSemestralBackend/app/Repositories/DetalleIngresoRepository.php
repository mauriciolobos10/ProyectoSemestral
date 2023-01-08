<?php

namespace App\Repositories;

use App\Models\ingreso;
use App\Models\DetalleIngresos;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DetalleIngresoRepository
{
    public function creardetIngreso($request)
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
            $detIngreso = new DetalleIngresos();
            $detIngreso->id_medicamento = $request->id_medicamento;
            $detIngreso->det_ingreso_id = $request->det_ingreso_id;//esta mal en el modelo del profe parece
            $detIngreso->det_ing_cantidad = $request->det_ing_cantidad;
            $detIngreso->det_ing_lote = $request->det_ing_lote;
            $detIngreso->save();
            return response()->json(["detalle ingreso" => $detIngreso], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminardetIngreso($request)
    {
        try {
            $detIngreso = DetalleIngresos::find($request->id);
            if(!$detIngreso){
                throw new Exception("No existe la detalle ingreso");
            }
            $detIngreso->delete();
            return response()->json(["Se ha eliminado el detalle ingreso"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizardetIngreso($request)
    {
        try {

            // $stock = Stock::where('med_nombre', $request->med_nombre)->
            // where('id', '!=' ,$request->id)->first();
            // if($stock){
            //     throw new Exception("Ya existe el nombre del Stock");
            // }


            $detIngreso = DetalleIngresos::findorFail($request->id);
            isset($request->id_medicamento) && $detIngreso->id_medicamento = $request->id_medicamento;
            isset($request->det_ingreso_id) && $detIngreso->det_ingreso_id = $request->det_ingreso_id;
            isset($request->det_ing_cantidad) && $detIngreso->det_ing_cantidad = $request->det_ing_cantidad;
            isset($request->det_ing_lote) && $detIngreso->det_ing_lote = $request->det_ing_lote;
            $detIngreso->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["ingreso" => $detIngreso], Response::HTTP_OK);
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

    public function veringreso($request)
    {
        try {
            $detIngreso = DetalleIngresos::where('id', $request->id)->first();
            if(!$detIngreso){
                throw new Exception("No se encuentra el Detalle ingreso");
            }

        return response()->json(["ingreso" => $detIngreso], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
