<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\IngresoRequest;
use App\Repositories\IngresoRepository;
use Illuminate\Http\Response;

class IngresoController extends Controller
{
    protected IngresoRepository $IngresoRepo;
    public function __construct(IngresoRepository $IngresoRepo)
    {
        $this->IngresoRepo = $IngresoRepo;
    }

    public function crearIngreso(Request $request)
    {   

        return $this->IngresoRepo->crearIngreso($request);
    }
    // public function actualizarFarmacia(IngresoRequest $request){
    //     return $this->IngresoRepo->actualizarIngreso($request);
    // }
    // public function eliminarFarmacia(Request $request){
    //     return $this->IngresoRepo->eliminarIngreso($request);
    // }
    // public function verFarmacia(Request $request){
    //     return $this->IngresoRepo->verIngreso($request);
    // }
}
