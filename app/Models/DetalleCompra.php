<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'subtotal',
        'producto_id',
        'orden_compra_id',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function ordenCompra(){
        return $this->belongsTo(OrdenCompra::class);
    }
}
