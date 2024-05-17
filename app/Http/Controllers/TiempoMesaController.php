<?php

namespace App\Http\Controllers;

use App\Models\TiempoMesa;
use Illuminate\Http\Request;

class TiempoMesaController extends Controller
{
    public function index()
    {
        try {
            $tiempos = TiempoMesa::all()->groupBy('billar');
            return response()->json($tiempos);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
    public function guardartiempo(Request $request)
    {
        try {
            // Validación de la solicitud
            $validatedData = $request->validate([
                'billar' => 'required|string',
                'mesa_id' => 'required|exists:mesas,id',
                'duracion' => 'required|string|regex:/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'pagado' => 'required|boolean',
            ]);
    
            // Convertir la duración a segundos
            $duracion = explode(':', $validatedData['duracion']);
            $segundos = ($duracion[0] * 3600) + ($duracion[1] * 60) + $duracion[2];
    
            // Crear el registro en la base de datos
            $tiempoMesa = TiempoMesa::create([
                'billar' => $validatedData['billar'],
                'mesa_id' => $validatedData['mesa_id'],
                'duracion' => $segundos, // Almacenar la duración en segundos
                'pagado' => $validatedData['pagado'],
            ]);
    
            // Responder con éxito
            return response()->json([
                'success' => true,
                'message' => 'Tiempo de mesa guardado exitosamente',
                'data' => $tiempoMesa
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación y devolver una respuesta detallada
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiempo de mesa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function marcarPagado($id)
{
    try {
        $tiempoMesa = TiempoMesa::findOrFail($id);
        $tiempoMesa->update(['pagado' => true]);

        return response()->json(['message' => 'Tiempo marcado como pagado']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
    
 // Otros métodos para show, update, destroy, etc.
}
    

   

    