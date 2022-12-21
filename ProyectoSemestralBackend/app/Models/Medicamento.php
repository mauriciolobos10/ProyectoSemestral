<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "med_nombre",
        "med_compuesto"
    ];
}
