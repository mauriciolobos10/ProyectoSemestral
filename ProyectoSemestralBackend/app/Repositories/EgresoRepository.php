<?php

namespace App\Repositories;

use App\Models\Egreso;
use App\Models\Farmacia;
use App\Models\CentroDistribucion;
use App\Models\DetalleEgresos;
use App\Models\Stock;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EgresoRepository
{
    public function crearEgreso($request)
    {     
        

        foreach($request->medicamentos as $medicamento){
            //Revisar que esten disponibles todos los medicamentos
            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])->
            where('scd_centro_dist', $request->egre_centro_dist)->first();

            //return response()->json(["tuiltimop" => $stock_actual], Response::HTTP_OK);
            //return response()->json(["tuiltimop" => $stock_actual['scd_cantidad']], Response::HTTP_OK);
            
            if(is_null($stock_actual) || $stock_actual['scd_cantidad'] < $medicamento['det_egr_cantidad']){
                return response()->json(["No hay Stock a egresar"], Response::HTTP_BAD_REQUEST);
            }

            //Si paso significa que estan todos los items
        }

        $egreso = New Egreso();
        $egreso->egre_fecha = $request->egre_fecha;
        $egreso->egre_centro_dist = $request->egre_centro_dist;
        $egreso->egre_farmacia_id = $request->egre_farmacia_id;
        $egreso->save();

        $id_ingresado = Egreso::latest('id')->first(); //ingresado en query de base de datos

        //return response()->json(["tuiltimop" => $id_ingresado['id']], Response::HTTP_OK);

        foreach($request->medicamentos as $medicamento){

            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])->
            where('scd_centro_dist', $request->egre_centro_dist)->get();


            try {
                $detEgreso = new DetalleEgresos();
                $detEgreso->id_medicamento = $medicamento['id_medicamento'];
                $detEgreso->det_egreso_id = $id_ingresado['id'];
                $detEgreso->det_egr_cantidad = $medicamento['det_egr_cantidad'];
                $detEgreso->det_egr_lote = $medicamento['det_egr_lote'];
                $detEgreso->save();
                    
        //return response()->json(["aaaa" => $detEgreso], Response::HTTP_OK);

            }catch (Exception $e) {
                return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }

            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])
            ->where('scd_centro_dist', $request->egre_centro_dist)->first();
                
            $valorDecrementar = $stock_actual['scd_cantidad'] - $medicamento['det_egr_cantidad'];

            $stock_actual->update(['scd_cantidad' => $valorDecrementar]);
            //return response()->json([$stock_actual], Response::HTTP_OK);
            
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
