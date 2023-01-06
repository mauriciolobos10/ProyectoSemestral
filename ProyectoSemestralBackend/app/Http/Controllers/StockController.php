<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use App\Repositories\StockRepository;
class StockController extends Controller
{
    protected StockRepository $stockRepo;
    public function __construct(StockRepository $medicamentoRepo)
    {
        $this->stockRepo = $medicamentoRepo;
    }

    public function crearFarmacia(StockRequest $request)
    {
        return $this->stockRepo->crearStock($request);
    }
    public function actualizarFarmacia(StockRequest $request){
        return $this->stockRepo->actualizarStock($request);
    }
    public function eliminarFarmacia(Request $request){
        return $this->stockRepo->eliminarStock($request);
    }
    public function verFarmacia(Request $request){
        return $this->stockRepo->verStock($request);
    }
}
