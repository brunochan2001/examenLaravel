<?php

namespace App\Http\Controllers\Api;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['socio', 'libro'])->get();

        return response()->json($reservas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'socio_id'         => 'required|exists:socios,id',
            'libro_id'         => 'required|exists:libros,id',
            'fecha_reserva'    => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_reserva',
            'estado'           => 'nullable|in:pendiente,devuelta',
        ]);

        $reservaActiva = Reserva::where('libro_id', $request->libro_id)
            ->where('estado', 'pendiente')
            ->exists();

        if ($reservaActiva) {
            return response()->json([
                'message' => 'Este libro ya tiene una reserva pendiente y no puede reservarse nuevamente'
            ], 409);
        }

        $reserva = Reserva::create([
            'socio_id'         => $request->socio_id,
            'libro_id'         => $request->libro_id,
            'fecha_reserva'    => $request->fecha_reserva,
            'fecha_devolucion' => $request->fecha_devolucion,
            'estado'           => $request->estado ?? 'pendiente',
        ]);

        return response()->json([
            'message' => 'Reserva registrada correctamente',
            'data' => $reserva->load(['socio', 'libro'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reserva = Reserva::with(['socio', 'libro'])->find($id);

        if (!$reserva) {
            return response()->json([
                'message' => 'Reserva no encontrada'
            ], 404);
        }

        return response()->json($reserva, 200);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, string $id)
    {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json([
                'message' => 'Reserva no encontrada'
            ], 404);
        }

        $request->validate([
            'socio_id'         => 'required|exists:socios,id',
            'libro_id'         => 'required|exists:libros,id',
            'fecha_reserva'    => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_reserva',
            'estado'           => 'nullable|in:pendiente,devuelta',
        ]);

        $estadoNuevo = $request->estado ?? $reserva->estado;

        if ($estadoNuevo === 'pendiente') {
            $reservaActiva = Reserva::where('libro_id', $request->libro_id)
                ->where('estado', 'pendiente')
                ->where('id', '!=', $reserva->id)
                ->exists();

            if ($reservaActiva) {
                return response()->json([
                    'message' => 'Este libro ya tiene otra reserva pendiente'
                ], 409);
            }
        }

        $reserva->update($request->only([
            'socio_id',
            'libro_id',
            'fecha_reserva',
            'fecha_devolucion',
            'estado'
        ]));

        return response()->json([
            'message' => 'Reserva actualizada correctamente',
            'data' => $reserva->load(['socio', 'libro'])
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return response()->json([
                'message' => 'Reserva no encontrada'
            ], 404);
        }

        $reserva->delete();

        return response()->json([
            'message' => 'Reserva eliminada correctamente'
        ], 200);
    }
}
