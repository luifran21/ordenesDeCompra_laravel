<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
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
        $validatorOrdenCompra = \Validator::make($request->orden_compra,[
            'fecha' => 'required',
            'cliente_id' => 'required'
        ]);
        if ($validatorOrdenCompra->fails()){
            return response()->json([
                "status" => False,
                "message" => $validatorOrdenCompra->errors(),
            ]);
        }

        foreach($request->detalles_compra as $detalle_compra){
            $validatorDetalleCompra = \Validator::make($detalle_compra,[
                'cantidad' => ['required','numeric'],
                'subtotal' => ['required','numeric'],
                'producto_id' => 'required'
            ]);
    
            if ($validatorDetalleCompra->fails()){
                return response()->json([
                    "status" => False,
                    "message" => $validatorDetalleCompra->errors(),
                ]);
            }
        }
        

        $ordenCompra = OrdenCompra::create($request->orden_compra);

        if(isset($ordenCompra)) {
            
            $ordenCompra->registrarDetalles($request->detalles_compra);

            return response()->json([
                "status" => True,
                "message" => "Orden registrada correctamente.",
            ]);
        }

        return response()->json([
            "status" => False,
            "message" => "Error al registrar la orden de compra.",
        ], 400);

    }

    /**
     * Display the specified resource.
     */
    public function show(OrdenCompra $ordenCompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrdenCompra $ordenCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenCompra $ordenCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrdenCompra $ordenCompra)
    {
        //
    }
}
