<?php
namespace App\Http\Controllers;
use App\Models\ESP32;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;



class ESP32Controller extends Controller
{
    public function updateStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'esp32_id' => 'required|string',
                'ip_address' => 'required|ip',
                'is_connected' => 'boolean'
            ]);

            // Buscar el ESP32 en la base de datos por su ID
            $esp32 = ESP32::where('esp32_id', $validatedData['esp32_id'])->first();

            if ($esp32) {
                // Actualizar la dirección IP y el estado de conexión
                $esp32->ip_address = $validatedData['ip_address'];
                $esp32->is_connected = $validatedData['is_connected'];
                $esp32->save();

                return response()->json(['message' => 'Estado del ESP32 actualizado exitosamente'], 200);
            } else {
                // Si el registro no existe, crea uno nuevo
                $esp32 = new ESP32();
                $esp32->esp32_id = $validatedData['esp32_id'];
                $esp32->ip_address = $validatedData['ip_address'];
                $esp32->is_connected = $validatedData['is_connected'];
                $esp32->save();

                return response()->json(['message' => 'Registro de ESP32 creado exitosamente'], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function checkInactivity()
    {
        $fiveMinutesAgo = Carbon::now()->subMinutes(5);
    
        // Actualizar el estado de conexión a "false" para los ESP32 que no han enviado actualizaciones en los últimos 5 minutos
        ESP32::where('updated_at', '<', $fiveMinutesAgo)->update(['is_connected' => false]);
    
        // Obtener todos los ESP32 que están inactivos
        $inactiveESP32s = ESP32::where('is_connected', false)->get();
    
        // Iterar sobre los ESP32 inactivos para verificar si alguno ha enviado una actualización reciente
        foreach ($inactiveESP32s as $esp32) {
            // Si el ESP32 ha enviado una actualización recientemente, cambiar su estado de conexión a "true"
            $latestActivity = $esp32->activities()->latest()->first();
            if ($latestActivity && $latestActivity->created_at >= $fiveMinutesAgo) {
                $esp32->is_connected = true;
                $esp32->save();
            }
        }
    
        return response()->json(['message' => 'Estado de inactividad actualizado'], 200);
    }
    
    
}
