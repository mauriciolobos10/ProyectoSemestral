<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEgresos extends Model
{
    use HasFactory;

    protected $table = 'detalle_egresos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "id_medicamento",
        "det_egr_cantidad",
        "det_egr_lote",
    ];

    public function egreso(){
        return $this->belongsTo(Egreso::class, "det_egreso_id");
    
    }
    public function medicamento(){
        return $this->hasMany(Medicamento::class);
    }

}
