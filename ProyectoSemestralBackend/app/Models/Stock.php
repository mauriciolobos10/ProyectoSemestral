<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "scd_cantidad",
        "scd_lote"
    ];

    public function medicamento(){
        return $this->belongsTo(Medicamento::class,"scd_id_medicamento");
    }

    public function centroDistribucion(){
        return $this->belongsTo(centroDistribucion::class,"scd_centro_distribucion");
    }
}
