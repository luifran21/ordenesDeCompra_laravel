<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Producto::paginate(10);

        return response()->json([
            "status" => True,
            "results" => $products
        ]);
    }
    public function getSugerencias(Request $request)
    {
        $productos = Producto::where('nombre', 'like', "%" . $request->clave . "%")->take(5)->get();

        return response()->json([
            "status" => "ok",
            "results" => $productos
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
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'unidades_de_medida' => 'required',
            'descripcion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first()
            ]);
        }

        $producto = Producto::create($request->all());

        if (isset($producto)) {
            return response()->json([
                'status' => true,
                'message' => "Producto registrado correctamente."
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => "Error al registrar el producto"
        ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return response()->json([
            "status" => true,
            "producto" => $producto
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validator = \Validator::make($request->all(), [
            'nombre' => 'nullable',
            'precio' => 'nullable|numeric|min:0',
            'unidades_de_medida' => 'nullable',
            'descripcion' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first()
            ],400);
        }

        try {
            $producto->update($request->all());
            $producto->save();

            if (isset($producto)) {
                return response()->json([
                    'status' => true,
                    'message' => "Producto actualizado correctamente."
                ], 200);
            }
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Error al registrar el producto. ".$e->getMessage(),
            ], 400);
        }

        return response()->json([
            'status' => false,
            'message' => "Error al registrar el producto"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try{
            if($producto->deleteOrFail()){
                return response()->json([
                    "status" => "ok",
                    "message" => "Producto eliminado correctamente."
                ],200);
            }
            return response()->json([
                "status" => "ok",
                "message" => "Producto no eliminado."
            ],400);
        }catch(\Exception $e){
            return response()->json([
                "status" => "error",
                "message" => "No se eliminó el producto porque está registrado en una o más ordenes de compra"//$e->getMessage()
            ],400);
        }
    }
}
