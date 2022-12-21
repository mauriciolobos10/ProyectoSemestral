<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Models\DetalleIngreso;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TestRepository
{

    public function listarLibros( $request)
    {

        $ingreso = New Ingreso();
        $ingreso->fecha = $request->fecha;
        $ingreso->cd = $request->centro_distribucion_id;
        $ingreso->save();


        foreach($request->medicamentos as $medicamento){
            $stock_actual = Stock::where([
                ['id_medicamento', $medicamento->id_medicamento],
                ['centro_dist', $request->centro_distribucion_id]
            ])->first();

            if(is_null($stock_actual)){
                // crear stock actual
            }else{
                $stock_actual = Stock::where([
                    ['id_medicamento', $medicamento->id_medicamento],
                    ['centro_dist', $request->centro_distribucion_id]
                ])->increment('cantidad', $medicamento->cantidad);
            }
        }
    }

    public function listarDetalleIngreso ($request){
        $detalle = DetalleIngreso::where('id_ingreso', $request->id->with('medicamento'));
    }


}
