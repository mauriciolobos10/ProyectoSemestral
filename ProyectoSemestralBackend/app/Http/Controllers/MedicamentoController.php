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

    public function crearMedicamento(MedicamentoRequest $request)
    {
        return $this->medicamentoRepo->crearMedicamento($request);
    }
    public function actualizarMedicamento(MedicamentoRequest $request){
        return $this->medicamentoRepo->actualizarMedicamento($request);
    }
    public function eliminarMedicamento(Request $request){
        return $this->medicamentoRepo->eliminarMedicamento($request);
    }
    public function verMedicamento(Request $request){
        return $this->medicamentoRepo->verMedicamento($request);
    }
    public function verMedicamentos(){
        return $this->medicamentoRepo->verMedicamentos();
    }
}
