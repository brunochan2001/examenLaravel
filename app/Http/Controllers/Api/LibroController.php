<?php

namespace App\Http\Controllers\Api;

use App\Models\Libro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libros = Libro::with('autores')->get();

        return response()->json($libros, 200);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'paginas'           => 'required|integer',
            'stock'             => 'required|integer',
            'fecha_publicacion' => 'required|date',
            'idioma'            => 'required|string|max:100',
            'autor_ids'         => 'required|array|min:1',
            'autor_ids.*'       => 'exists:autores,id',
        ]);

        $libro = Libro::create($request->only([
            'titulo',
            'descripcion',
            'paginas',
            'stock',
            'fecha_publicacion',
            'idioma'
        ]));


        $libro->autores()->attach($request->autor_ids);

        return response()->json([
            'message' => 'Libro registrado correctamente',
            'data' => $libro->load('autores')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = Libro::with('autores')->find($id);

        if (!$libro) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        return response()->json($libro, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'paginas'           => 'required|integer',
            'stock'             => 'required|integer',
            'fecha_publicacion' => 'required|date',
            'idioma'            => 'required|string|max:100',
            'autor_ids'         => 'required|array|min:1',
            'autor_ids.*'       => 'exists:autores,id',
        ]);

        $libro->update($request->only([
            'titulo',
            'descripcion',
            'paginas',
            'stock',
            'fecha_publicacion',
            'idioma'
        ]));

        $libro->autores()->sync($request->autor_ids);

        return response()->json([
            'message' => 'Libro actualizado correctamente',
            'data' => $libro->load('autores')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $libro->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente'
        ], 200);
    }
}
