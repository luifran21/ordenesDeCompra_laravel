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
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function detallesCompra(){
        return $this->hasMany(DetalleCompra::class)->with('producto');
    }

    public function registrarDetalles(Array $detalles){
        $detalleCompraController = new DetalleCompraController();

        $detalles_db = $detalleCompraController->registrarDetalles($detalles, $this);
        
        if (count($detalles_db) > 0) {
            return True;
        }

        return False;
    }
}
