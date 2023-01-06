<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MedicamentoRequest;
use App\Repositories\MedicamentoRepository;

class MedicamentoController extends Controller
{
    protected MedicamentoRepository $medicamentoRepo;
    public function __construct(MedicamentoRepository $medicamentoRepo)
    {
        $this->medicamentoRepo = $medicamentoRepo;
    }

    public function crearFarmacia(MedicamentoRequest $request)
    {
        return $this->medicamentoRepo->crearMedicamento($request);
    }
    public function actualizarFarmacia(MedicamentoRequest $request){
        return $this->medicamentoRepo->actualizarMedicamento($request);
    }
    public function eliminarFarmacia(Request $request){
        return $this->medicamentoRepo->eliminarMedicamento($request);
    }
    public function verFarmacia(Request $request){
        return $this->medicamentoRepo->verMedicamento($request);
    }
}
