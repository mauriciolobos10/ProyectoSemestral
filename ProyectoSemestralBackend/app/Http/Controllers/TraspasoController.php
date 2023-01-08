<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TraspasoRequest;
use App\Repositories\TraspasoRepository;
use Illuminate\Http\Response;

class TraspasoController extends Controller
{
    protected TraspasoRepository $TraspasoRepo;
    public function __construct(TraspasoRepository $TraspasoRepo)
    {
        $this->TraspasoRepo = $TraspasoRepo;
    }

    public function crearTraspaso(Request $request)
    {   

        return $this->TraspasoRepo->crearTraspaso($request);
    }
}
