<?php

namespace App\Repositories;

use App\Models\Medicamento;
use Exception;
use Faker\Provider\Medical;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MedicamentoRepository
{
    public function crearMedicamento($request)
    {     
        try {
            $medicamento = Medicamento::where('med_nombre', $request->med_nombre)->first();
            if($medicamento){
                throw new Exception("Ya existe el nombre de medicamento");
            }
            $medicamento = new Medicamento();
            $medicamento->med_nombre = $request->med_nombre;
            $medicamento->med_compuesto = $request->med_compuesto;
            $medicamento->save();
            return response()->json(["medicamento" => $medicamento], Response::HTTP_OK);
            
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        
    }

    public function eliminarMedicamento($request)
    {
        try {
            $medicamento = Medicamento::find($request->id);
            if(!$medicamento){
                throw new Exception("No existe el medicamento");
            }
            $medicamento->delete();
            return response()->json(["Se ha eliminado el medicamento"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarMedicamento($request)
    {
        try {

            $medicamento = Medicamento::where('med_nombre', $request->med_nombre)->
            where('id', '!=' ,$request->id)->first();
            if($medicamento){
                throw new Exception("Ya existe el nombre del medicamento");
            }
            
            $medicamento = Medicamento::findorFail($request->id);
            isset($request->med_nombre) && $medicamento->med_nombre = $request->med_nombre;
            isset($request->med_compuesto) && $medicamento->med_compuesto = $request->med_compuesto;
            $medicamento->save();
            //  $farmacia = Farmacia::where('id', $request->id)
            //      ->update([
            //          'farm_nombre' => $request->farm_nombre,
            //          'farm_direccion' => $request->farm_direccion,
            //          'farm_mail' => $request->farm_mail,
            //      ]);

            return response()->json(["Medicamento" => $medicamento], Response::HTTP_OK);
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

    public function verMedicamento($request)
    {
        try {
            $medicamento = Medicamento::where('id', $request->id)->first();
            if(!$medicamento){
                throw new Exception("No se encuentra el Medicamento");
            }

        return response()->json(["farmacia" => $medicamento], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
