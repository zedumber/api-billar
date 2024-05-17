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
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
