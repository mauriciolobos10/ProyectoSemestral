<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "ingr_fecha",
    ];

    public function detalleIngreso(){
        return $this->hasMany(detalleIngreso::class);
    }

    public function centroDistribucion()
    {
        return $this->belongsTo(centroDistribucion::class, "ingr_centro_dist");
    }
}
