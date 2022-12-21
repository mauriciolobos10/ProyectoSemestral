<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmacia extends Model
{
    use HasFactory;

    protected $table = 'farmacias';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        "farm_nombre",
        "farm_direccion",
        "farm_mail"
    ];
    
    public function egreso(){
        return $this->hasMany(Egreso::class);
    }
}
