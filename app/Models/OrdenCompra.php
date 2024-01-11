<?php

namespace App\Models;

use App\Http\Controllers\DetalleCompraController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function getDetallesCompra(){
        return $this->hasMany(DetalleCompra::class);
    }

    public function registrarDetalles(Array $detalles){
        $detalleCompraController = new DetalleCompraController();

        $detalles_db = $detalleCompraController->registrarDetalles($detalles, $this); // hacer la funcion en el controller
        
        if (count($detalles_db) > 0) {
            return True;
        }

        return False;
    }
}
