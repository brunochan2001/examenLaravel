<?php

namespace App\Http\Controllers\Api;

use App\Models\Socio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socios = Socio::with('reservas')->get();

        return response()->json($socios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni'      => 'required|string|max:20|unique:socios,dni',
            'email'    => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $socio = Socio::create($request->only([
            'nombre',
            'apellido',
            'dni',
            'email',
            'telefono'
        ]));

        return response()->json([
            'message' => 'Socio registrado correctamente',
            'data' => $socio
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $socio = Socio::with('reservas.libro')->find($id);

        if (!$socio) {
            return response()->json([
                'message' => 'Socio no encontrado'
            ], 404);
        }

        return response()->json($socio, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socio = Socio::find($id);

        if (!$socio) {
            return response()->json([
                'message' => 'Socio no encontrado'
            ], 404);
        }

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni'      => 'required|string|max:20|unique:socios,dni,' . $socio->id,
            'email'    => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $socio->update($request->only([
            'nombre',
            'apellido',
            'dni',
            'email',
            'telefono'
        ]));

        return response()->json([
            'message' => 'Socio actualizado correctamente',
            'data' => $socio
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socio = Socio::find($id);

        if (!$socio) {
            return response()->json([
                'message' => 'Socio no encontrado'
            ], 404);
        }

        $socio->delete();

        return response()->json([
            'message' => 'Socio eliminado correctamente'
        ], 200);
    }
}
