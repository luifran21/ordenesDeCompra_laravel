<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;

class DetalleCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function registrarDetalles(Array $detalles, OrdenCompra $ordenCompra)
    {
        $detalles_db = [];

        foreach ($detalles as $detalle) {
            $detalle_db = DetalleCompra::create([
                'cantidad' => $detalle["cantidad"],
                'subtotal' => $detalle["subtotal"],
                'orden_compra_id' => $ordenCompra->id,
                'producto_id' => $detalle["producto_id"]
            ]);

            if (isset($detalle_db)) {
                array_push($detalles_db, $detalle_db);
            }
        }

        return $detalles_db;
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleCompra $detalleCompra)
    {
        //
    }
}
