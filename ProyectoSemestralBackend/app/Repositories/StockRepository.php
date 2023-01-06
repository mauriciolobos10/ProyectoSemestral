<?php

namespace App\Repositories;

use App\Models\Stock;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StockRepository
{
    public function crearStock($request)
    {     
        try {
            // $stock = Stock::where('med_nombre', $request->med_nombre)->first();
            // if($medicamento){
            //     throw new Exception("Ya existe el nombre de medicamento");
            // }
            $stock = new Stock();
            $stock->scd_id_medicamento = $request->scd_id_medicamento;
            $stock->scd_centro_distribucion = $request->scd_centro_distribucion;
            $stock->scd_cantidad = $request->scd_cantidad;
            $stock->scd_lote = $request->scd_lote;
            $stock->save();
            return response()->json(["stock" => $stock], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminarStock($request)
    {
        try {
            $stock = Stock::find($request->id);
            if(!$stock){
                throw new Exception("No existe el stock");
            }
            $stock->delete();
            return response()->json(["Se ha eliminado el stock"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarStock($request)
    {
        try {

            // $stock = Stock::where('med_nombre', $request->med_nombre)->
            // where('id', '!=' ,$request->id)->first();
            // if($stock){
            //     throw new Exception("Ya existe el nombre del Stock");
            // }

            
            $stock = Stock::findorFail($request->id);
            isset($request->med_nscd_id_medicamentoombre) && $stock->scd_id_medicamento = $request->scd_id_medicamento;
            isset($request->scd_centro_distribucion) && $stock->scd_centro_distribucion = $request->scd_centro_distribucion;
            isset($request->scd_cantidad) && $stock->scd_id_medicamento = $request->scd_cantidad;
            isset($request->scd_lote) && $stock->scd_lote = $request->scd_lote;
            $stock->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["stock" => $stock], Response::HTTP_OK);
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

    public function verStock($request)
    {
        try {
            $stock = Stock::where('id', $request->id)->first();
            if(!$stock){
                throw new Exception("No se encuentra el Stock");
            }

        return response()->json(["stock" => $stock], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
