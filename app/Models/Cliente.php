<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'direccion',
    ];

    public function ordenCompra(){
        return $this->hasMany(OrdenCompra::class);
    }

}
