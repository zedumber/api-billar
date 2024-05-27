<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;



class ConfigurationController extends Controller
{
 /**
     * Obtiene el nombre y la clave de la red WiFi desde la configuración.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWiFiConfiguration()
    {
        try {
            $config = Configuration::firstOrFail(); // Suponiendo que tienes un modelo Configuration
    
            return response()->json([
                'ssid' => $config->wifi_ssid,
                'password' => $config->wifi_password,
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Error al obtener la configuración de WiFi: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo encontrar la configuración de WiFi'], 404);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener la configuración de WiFi: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Obtiene el precio por hora desde la configuración.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPriceConfiguration()
    {
        try {
            $config = Configuration::firstOrFail(); // Suponiendo que tienes un modelo Configuration
    
            return response()->json([
                'price_per_hour' => $config->price_per_hour,
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Error al obtener la configuración de precio por hora: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo encontrar la configuración de precio por hora'], 404);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener la configuración de precio por hora: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function saveConfiguration(Request $request)
{
    // Validar los datos recibidos del cliente
    $validator = Validator::make($request->all(), [
        'wifi_ssid' => 'required|string',
        'wifi_password' => 'required|string',
        'price_per_hour' => 'required|numeric',
    ]);

    // Si la validación falla, devolver una respuesta de error
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    try {
        // Crear una nueva instancia de Configuration o actualizar la existente
        $config = Configuration::firstOrNew();

        // Actualizar los datos de configuración
        $config->wifi_ssid = $request->wifi_ssid;
        $config->wifi_password = $request->wifi_password;
        $config->price_per_hour = $request->price_per_hour;

        // Guardar la configuración en la base de datos
        $config->save();

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Configuración guardada correctamente'], 200);
    } catch (\Exception $e) {
        // Loguear cualquier error inesperado
        Log::error('Error inesperado al guardar la configuración: ' . $e->getMessage());

        // Devolver una respuesta de error interno del servidor
        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}
}