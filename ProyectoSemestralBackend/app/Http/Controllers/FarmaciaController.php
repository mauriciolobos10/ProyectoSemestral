<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmaciaRequest;
use App\Repositories\FarmaciaRepository;
use Illuminate\Http\Request;

class FarmaciaController extends Controller
{
    protected FarmaciaRepository $farmaciaRepo;
    public function __construct(FarmaciaRepository $farmaciaRepo)
    {
        $this->farmaciaRepo = $farmaciaRepo;
    }

    public function crearFarmacia(FarmaciaRequest $request)
    {
        return $this->farmaciaRepo->crearFarmacia($request);
    }
    public function actualizarFarmacia(FarmaciaRequest $request){
        return $this->farmaciaRepo->actualizarFarmacia($request);
    }
    public function eliminarFarmacia(Request $request){
        return $this->farmaciaRepo->eliminarFarmacia($request);
    }
    public function verFarmacia(Request $request){
        return $this->farmaciaRepo->verFarmacia($request);
    }
}
