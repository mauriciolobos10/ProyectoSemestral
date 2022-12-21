<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;

    protected $table = 'egresos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "egre_fecha",
    ];

    public function farmacia(){
        return $this->belongsTo(farmacia::class, "egre_farmacia_id");
    }

    public function detalleEgreso(){
        return $this->hasMany(detalleEgreso::class);
    }

    public function centroDistribucion()
    {
        return $this->belongsTo(centroDistribucion::class, "egre_centro_dist");
    }
}
