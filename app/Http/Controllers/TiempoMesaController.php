<?php

namespace App\Http\Controllers;

use App\Models\TiempoMesa;
use Illuminate\Http\Request;

class TiempoMesaController extends Controller
{
    public function index()
    {
        $tiempos = TiempoMesa::all();
        return response()->json($tiempos);
    }
    public function guardartiempo(Request $request)
    {
        try {
            $request->validate([           
                'mesa_id' => 'required|exists:mesas,id',
                'tiempo_inicio' => 'required|date_format:H:i:s',
                'tiempo_fin' => 'required|date_format:H:i:s',
            ]);
    
            // Convertir los tiempos al formato de MySQL
            $tiempo_inicio = date('Y-m-d H:i:s', strtotime('today ' . $request->tiempo_inicio));
            $tiempo_fin = date('Y-m-d H:i:s', strtotime('today ' . $request->tiempo_fin));
    
            $tiempoMesa = TiempoMesa::create([          
                'mesa_id' => $request->mesa_id,
                'tiempo_inicio' => $tiempo_inicio,
                'tiempo_fin' => $tiempo_fin,
            ]);
    
            return response()->json($tiempoMesa, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
 // Otros métodos para show, update, destroy, etc.
}
    

   

    