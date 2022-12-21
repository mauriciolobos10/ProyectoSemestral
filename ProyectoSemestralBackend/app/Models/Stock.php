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
        "scd_id_medicamento",
        "scd_cantidad",
        "scd_centro_distribucion",
        "scd_lote"
    ];

    public function medicamento(){
        return $this->hasMany(Medicamento::class);
    }

    public function centroDistribucion(){
        return $this->hasMany(centroDistribucion::class);
    }
}
