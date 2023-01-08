<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EgresoRequest;
use App\Repositories\EgresoRepository;

class EgresoController extends Controller
{
    protected EgresoRepository $egresoRepo;
    public function __construct(EgresoRepository $egresoRepo)
    {
        $this->egresoRepo = $egresoRepo;
    }

    public function crearEgreso(EgresoRequest $request)
    {
        return $this->egresoRepo->crearEgreso($request);
    }
    public function actualizarEgreso(EgresoRequest $request){
        return $this->egresoRepo->actualizarEgreso($request);
    }
    public function eliminarEgreso(Request $request){
        return $this->egresoRepo->eliminarEgreso($request);
    }
    public function verEgreso(Request $request){
        return $this->egresoRepo->verEgreso($request);
    }
}
