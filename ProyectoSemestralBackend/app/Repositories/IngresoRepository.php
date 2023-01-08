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
    private $detIngresoRepo;
    private $StockRepo;

    function __construct(){
        $this->detIngresoRepo = new DetalleIngresoRepository();
        $this->StockRepo = new StockRepository();
    }


    public function crearIngreso( $request)
    {   


        $ingreso = New Ingreso();
        $ingreso->ingr_fecha = $request->ingr_fecha;
        $ingreso->ingr_centro_dist = $request->ingr_centro_dist;
        $ingreso->save();

        //return response()->json(["alo egreso" => $ingreso], Response::HTTP_OK);

        foreach($request->medicamentos as $medicamento){

        //return response()->json([$medicamento], Response::HTTP_OK);
            $stock_actual = Stock::where([
                ['scd_id_medicamento', $medicamento['id_medicamento']],
                ['scd_centro_dist', $request->ingr_centro_dist]
            ])->first();

            return response()->json(["alo egreso" ], Response::HTTP_OK);
            if(is_null($stock_actual)){
                // crear stock actual
                $this->detIngresoRepo->crearDetIngreso($medicamento);
                //$this->StockRepo->crearStock($medicamento);

            }else{
                $stock_actual = Stock::where([
                    ['id_medicamento', $medicamento->id_medicamento],
                    ['centro_dist', $request->centro_distribucion_id]
                ])->increment('cantidad', $medicamento->cantidad);
            }
        }
    }

    public function listarDetalleIngreso ($request){
        $detalle = DetalleIngresos::where('id_ingreso', $request->id->with('medicamento'));
    }


}
