<?php

namespace App\Http\Controllers;

use App\Http\Requests\CentroDistribucionRequest;
use App\Repositories\CentroDistribucionRepository;
use Illuminate\Http\Request;

class CentroDistribucionController extends Controller
{
    protected CentroDistribucionRepository $centroRepo;
    public function __construct(CentroDistribucionRepository $centroRepo)
    {
        $this->centroRepo = $centroRepo;
    }

    public function crearCentro(CentroDistribucionRequest $request)
    {
        return $this->centroRepo->crearCentro($request);
    }
    public function actualizarCentro(CentroDistribucionRequest $request){
        return $this->centroRepo->actualizarCentro($request);
    }
    public function eliminarCentro(Request $request){
        return $this->centroRepo->eliminarCentro($request);
    }
    public function verCentro(Request $request){
        return $this->centroRepo->verCentro($request);
    }
}
