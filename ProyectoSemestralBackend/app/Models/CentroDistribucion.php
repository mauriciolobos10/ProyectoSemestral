<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDistribucion extends Model
{
    use HasFactory;

    protected $table = 'centro_distribucions';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "cd_codigo",
        "cd_direccion",
        "cd_telefono"
    ];


}
