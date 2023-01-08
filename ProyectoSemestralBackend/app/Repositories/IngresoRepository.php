<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Models\DetalleIngreso;
use App\Models\DetalleIngresos;
use App\Repositories\DetalleIngresoRepository;
use App\Repositories\StockRepository;
use App\Models\Ingreso;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class IngresoRepository
{
    // private $detIngresoRepo;
    // private $StockRepo;

    protected DetalleIngresoRepository $detIngresoRepo;
    public function __construct(DetalleIngresoRepository $detIngresoRepo)
    {
        $this->detIngresoRepo = $detIngresoRepo;
    }

    // function __construct(){
    //     $this->detIngresoRepo = new DetalleIngresoRepository();
    //     $this->StockRepo = new StockRepository();
    // }


    public function crearIngreso( $request)
    {   


        $ingreso = New Ingreso();
        $ingreso->ingr_fecha = $request->ingr_fecha;
        $ingreso->ingr_centro_dist = $request->ingr_centro_dist;
        $ingreso->save();

        //return response()->json(["alo egreso" => $ingreso], Response::HTTP_OK);

        foreach($request->medicamentos as $medicamento){

        //return response()->json([$request->ingr_centro_dist , $medicamento['id_medicamento']], Response::HTTP_OK);
            // $stock_actual = Stock::where([
            //     ['scd_id_medicamento', $medicamento['id_medicamento']],
            //     ['scd_centro_dist', $request->ingr_centro_dist]
            // ])->first();
            // $stock_actual = Stock::all();
            // return response()->json([$request->medicamentos], Response::HTTP_OK);
            $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])->
            where('scd_centro_dist', $request->ingr_centro_dist)->get();
            //Crea Detalle ingreso
            try {
                $detIngreso = new DetalleIngresos();
                $detIngreso->id_medicamento = $medicamento['id_medicamento'];
                $detIngreso->det_ingreso_id = $medicamento['det_ingreso_id'];//esta mal en el modelo del profe parece
                $detIngreso->det_ing_cantidad = $medicamento['det_ing_cantidad'];
                $detIngreso->det_ing_lote = $medicamento['det_ing_lote'];
                $detIngreso->save();
                //return response()->json(["detalle ingreso" => $detIngreso], Response::HTTP_OK);
                
            }catch (Exception $e) {
                return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }
            //return response()->json(["AA" => $stock_actual], Response::HTTP_OK);

            if($stock_actual->isEmpty()){
                //crear stock
                //return response()->json(["ta ma" => $stock_actual], Response::HTTP_OK);
                try {
                    $stock = new Stock();
                    $stock->scd_id_medicamento = $medicamento['id_medicamento'];
                    $stock->scd_centro_dist = $request->ingr_centro_dist;
                    $stock->scd_cantidad = $medicamento['det_ing_cantidad'];
                    $stock->scd_lote = $medicamento['det_ing_lote'];
                    $stock->save();
                    
                    
                }catch (Exception $e) {
                    return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
                }

                


                // // crear stock actual
                // $this->detIngresoRepo->crearDetIngreso($medicamento);
                // //$this->StockRepo->crearStock($medicamento);
                // //return response()->json(["alo egreso" ], Response::HTTP_OK);
            }else{
                //sreturn response()->json(["paso" => $stock_actual], Response::HTTP_OK);

                // $stock_actual = Stock::where([
                //     ['scd_id_medicamento', $medicamento['id_medicamento']],
                //     ['scd_centro_dist', $request->centro_distribucion_id]
                // ])->increment('scd_cantidad', $medicamento['det_ing_cantidad']);

                $stock_actual = Stock::where('scd_id_medicamento', $medicamento['id_medicamento'])
                ->where('scd_centro_dist', $request->ingr_centro_dist)->first();
                
                //return response()->json(["prueba" => $stock_actual], Response::HTTP_OK);
                
                $valorIncrementar = $stock_actual['scd_cantidad'] + $medicamento['det_ing_cantidad'];

                $stock_actual->update(['scd_cantidad' => $valorIncrementar]);
                //return response()->json([$stock_actual], Response::HTTP_OK);
                

            }

            //s$medicamento = null; 
        }
    }

    public function listarDetalleIngreso ($request){
        $detalle = DetalleIngresos::where('id_ingreso', $request->id->with('medicamento'));
    }


}
