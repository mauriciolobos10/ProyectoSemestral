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
        "det_ing_cantidad",
        "det_ing_lote",
    ];

    public function medicamento(){
        return $this->hasMany(Medicamento::class);
    }

    public function ingreso(){
        return $this->belongsTo(Ingreso::class, "det_ingreso_id");
    }
}
