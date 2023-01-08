<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetalleEgresoRequest;
use App\Repositories\DetalleEgresoRepository;

class DetalleEgresosController extends Controller
{
    protected DetalleEgresoRepository $detEgresoRepo;
    public function __construct(DetalleEgresoRepository $detEgresoRepo)
    {
        $this->detEgresoRepo = $detEgresoRepo;
    }

    public function crearFarmacia(DetalleEgresoRequest $request)
    {
        return $this->detEgresoRepo->crearDetEgreso($request);
    }
    public function actualizarFarmacia(DetalleEgresoRequest $request){
        return $this->detEgresoRepo->actualizarDetEgreso($request);
    }
    public function eliminarFarmacia(Request $request){
        return $this->detEgresoRepo->eliminarDetEgreso($request);
    }
    public function verFarmacia(Request $request){
        return $this->detEgresoRepo->verEgreso($request);
    }
}
