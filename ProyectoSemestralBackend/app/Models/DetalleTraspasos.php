<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTraspasos extends Model
{
    protected $table = 'detalle_traspasos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "det_tra_cantidad",
        "det_tra_lote"
    ];

    public function traspaso(){
        return $this->belongsTo(Traspaso::class,"det_traspaso_id");
    }
    public function medicamento(){
        return $this->belongsTo(Medicamento::class,"id_medicamento");
    }
}
