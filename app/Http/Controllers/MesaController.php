<?php
namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
//probando con esto
class MesaController extends Controller
{
    public function crearMesa(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
            ]);
    
            $mesa = Mesa::create([
                'nombre' => $request->nombre,
            ]);
    
            return response()->json($mesa, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear la mesa: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'Se produjo un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }
    
}
