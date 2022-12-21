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
        "egre_centro_dist",
        "egre_farmacia_id",
    ];

    public function farmacia(){
        return $this->hasMany(Farmacia::class);
    }

    public function centroDistribucion(){
        return $this->hasMany(centroDistribucion::class);
    }
}
