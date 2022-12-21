<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngresos extends Model
{
    use HasFactory;

    protected $table = 'detalle_ingresos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "id_medicamento",
        "det_ingreso_cantidad",
        "det_ingreso_lote",
    ];

    public function medicamento(){
        return $this->hasMany(Medicamento::class);
    }

    public function ingreso(){
        return $this->belongsTo(ingreso::class, "det_ingreso_id");
    }
}
