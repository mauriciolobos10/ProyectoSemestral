<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    use HasFactory;

    protected $table = 'traspasos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "tras_estado",
    ];

    public function centroDistribucionOrigen(){
        return $this->belongsTo(CentroDistribucion::class,"tras_cd_origen");
    }

    public function centroDistribucionDestino(){
        return $this->belongsTo(CentroDistribucion::class,"tras_cd_destino");
    }

    public function detalleTraspaso(){
        return $this->hasMany(DetalleTraspasos::class);
    }


}
