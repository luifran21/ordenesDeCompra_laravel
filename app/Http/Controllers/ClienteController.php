<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return response()->json([
            "status" => true,
            "results" => $clientes
        ],200);
    }
    public function getSugerencias(Request $request)
    {
        $clientes = Cliente::where('nombre','like', "%".$request->clave."%")->take(5)->get();

        return response()->json([
            "status" => "ok",
            "results" => $clientes
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
        $validator = \Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'direccion' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first()
            ],400);
        }

        $cliente = Cliente::create($request->all());

        if(isset($cliente)){
            return response()->json([
                'status' => true,
                'message' => "Cliente registrado correctamente."
            ],200);
        }

        return response()->json([
            'status' => true,
            'message' => "Ocurrio un error al registrar el cliente"
        ],400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validator = \Validator::make($request->all(),[
            'nombre' => 'nullable',
            'apellido' => 'nullable',
            'direccion' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first()
            ],400);
        }

        $cliente->update($request->all());
        $cliente->save();

        if(isset($cliente)){
            return response()->json([
                'status' => true,
                'message' => "Cliente actualizado correctamente."
            ],200);
        }

        return response()->json([
            'status' => true,
            'message' => "Ocurrio un error al registrar el cliente"
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try{
            $cliente->delete();
        }catch(\Exception $e){
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }

        return response()->json([
            "status" => "ok",
            "message" => "Cliente eliminado correctamente"
        ]);
    }
}
