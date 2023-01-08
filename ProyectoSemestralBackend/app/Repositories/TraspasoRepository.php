<?php

namespace App\Repositories;

use App\Models\Traspaso;
use App\Models\Farmacia;
use App\Models\CentroDistribucion;
use App\Models\DetalleTraspasos;
use App\Models\Stock;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TraspasoRepository
{
    public function crearTraspaso($request)
    {     
        foreach($request->medicamentos as $medicamento){
            //Revisar que esten disponibles todos los medicamentos
            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])->
            where('scd_centro_dist', $request->tras_cd_origen)->first();

            //return response()->json(["tuiltimop" => $stock_actual], Response::HTTP_OK);
            //return response()->json(["tuiltimop" => $stock_actual['scd_cantidad']], Response::HTTP_OK);
            
            if(is_null($stock_actual) || $stock_actual['scd_cantidad'] < $medicamento['det_tra_cantidad']){
                return response()->json(["No hay Stock a traspasar"], Response::HTTP_BAD_REQUEST);
            }

            //Si paso significa que estan todos los items
        }   

        $traspaso = New Traspaso();
        $traspaso->tras_cd_origen = $request->tras_cd_origen;
        $traspaso->tras_cd_destino = $request->tras_cd_destino;
        $traspaso->tras_estado = $request->tras_estado;
        $traspaso->save();


        //return response()->json(["prueba" => $traspaso], Response::HTTP_OK);


        $id_ingresado = Traspaso::latest('id')->first(); //ingresado en query de base de datos

        foreach($request->medicamentos as $medicamento){

            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])->
            where('scd_centro_dist', $request->tras_cd_origen)->get();

            try {
                

                $dettraspaso = new DetalleTraspasos();
                $dettraspaso->id_medicamento = $medicamento['id_medicamento'];
                $dettraspaso->det_traspaso_id = $id_ingresado['id'];
                $dettraspaso->det_tra_cantidad = $medicamento['det_tra_cantidad'];
                $dettraspaso->det_tra_lote = $medicamento['det_tra_lote'];
                $dettraspaso->save();
                
                //return response()->json(["prueba" => $dettraspaso], Response::HTTP_OK);


            }catch (Exception $e) {
                return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }

            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])
            ->where('scd_centro_dist', $request->tras_cd_origen)->first();
                
            $valorDecrementar = $stock_actual['scd_cantidad'] - $medicamento['det_tra_cantidad'];

            $stock_actual->update(['scd_cantidad' => $valorDecrementar]);

            //verificar si existe el stock en el centro destino
            
            $stock_destino = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])
            ->where('scd_centro_dist', $request->tras_cd_destino)->first();
            
            //si no existe se crea
            if(is_null($stock_destino)){
                $stock = new Stock();
                $stock->scd_id_medicamento = $medicamento['id_medicamento'];
                $stock->scd_centro_dist = $request->tras_cd_destino;
                $stock->scd_cantidad = $medicamento['det_tra_cantidad'];
                $stock->scd_lote = $medicamento['det_tra_lote'];
                $stock->save();
            }else{//si existe se updatea
                $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])
                ->where('scd_centro_dist', $request->tras_cd_destino)->first();
                
                //return response()->json(["prueba" => $stock_actual], Response::HTTP_OK);
                
                $valorIncrementar = $stock_actual['scd_cantidad'] + $medicamento['det_tra_cantidad'];

                $stock_actual->update(['scd_cantidad' => $valorIncrementar]);
            }
            
        }
    }

















    public function eliminartraspaso($request)
    {
        try {
            $traspaso = traspaso::find($request->id);
            if(!$traspaso){
                throw new Exception("No existe la farmacia");
            }
            $traspaso->delete();
            return response()->json(["Se ha eliminado el traspaso"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizartraspaso($request)
    {
        try {

            // $stock = Stock::where('med_nombre', $request->med_nombre)->
            // where('id', '!=' ,$request->id)->first();
            // if($stock){
            //     throw new Exception("Ya existe el nombre del Stock");
            // }

            $traspaso = traspaso::findorFail($request->id);
            isset($request->tras_centro_dist) && $traspaso->tras_centro_dist = $request->tras_centro_dist;
            isset($request->tras_farmacia_id) && $traspaso->tras_farmacia_id = $request->tras_farmacia_id;
            isset($request->tras_fecha) && $traspaso->scd_id_medicamento = $request->tras_fecha;
            $traspaso->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["traspaso" => $traspaso], Response::HTTP_OK);
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

    public function vertraspaso($request)
    {
        try {
            $traspaso = traspaso::where('id', $request->id)->first();
            if(!$traspaso){
                throw new Exception("No se encuentra el traspaso");
            }

        return response()->json(["traspaso" => $traspaso], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
