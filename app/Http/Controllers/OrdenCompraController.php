<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use Illuminate\Http\Request;
use App\Models\Cliente;

class OrdenCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = OrdenCompra::with('detallesCompra')->with('cliente')->paginate(10);
        if (isset($ordenes)) {
            return response()->json([
                "status" => true,
                "results" => $ordenes
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "No se encontraron ordenes."
        ]);
    }
    public function filter(Request $request)
    {
        $cliente = $request->cliente;

        $fecha = $request->fecha;

        if ($fecha && $cliente) {

            $ordenes = OrdenCompra::with('cliente')
                ->whereHas('cliente', function ($query) use ($cliente) {
                    $query->whereRaw('CONCAT(nombre, " ", apellido) LIKE ?', ['%' . $cliente . '%']);
                })
                ->where('fecha', $fecha)
                ->with('detallesCompra')
                ->paginate(10);

        }

        if ($fecha && !$cliente) {
            $ordenes = OrdenCompra::where('fecha', $fecha)->with('cliente', 'detallesCompra')->paginate(10);
        }

        if (!$fecha && $cliente) {
            $ordenes = OrdenCompra::with('cliente')
                ->whereHas('cliente', function ($query) use ($cliente) {
                    $query->whereRaw('CONCAT(nombre, " ", apellido) LIKE ?', ['%' . $cliente . '%']);
                })
                ->with('detallesCompra')
                ->paginate(10);
        }

        if (isset($ordenes)) {
            return response()->json([
                "status" => true,
                "results" => $ordenes,
                "cliente" => $cliente
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "No se encontraron ordenes."
        ]);
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
        $validatorOrdenCompra = \Validator::make($request->orden_compra, [
            'fecha' => 'required',
            'cliente_id' => 'required'
        ]);
        if ($validatorOrdenCompra->fails()) {
            return response()->json([
                "status" => False,
                "message" => $validatorOrdenCompra->errors(),
            ], 400);
        }

        foreach ($request->detalles_compra as $detalle_compra) {
            $validatorDetalleCompra = \Validator::make($detalle_compra, [
                'cantidad' => ['required', 'numeric', 'min:1'],
                'subtotal' => ['required', 'numeric', 'min:0'],
                'producto_id' => 'required'
            ]);

            if ($validatorDetalleCompra->fails()) {
                return response()->json([
                    "status" => False,
                    "message" => $validatorDetalleCompra->errors()->first(),
                ], 400);
            }
        }


        $ordenCompra = OrdenCompra::create($request->orden_compra);

        if (isset($ordenCompra)) {

            $ordenCompra->registrarDetalles($request->detalles_compra);

            return response()->json([
                "status" => True,
                "message" => "Orden registrada correctamente.",
            ], 200);
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
