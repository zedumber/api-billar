<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\ESP32;


class CheckEsp32Inactivity extends Command
{
    protected $signature = 'esp32:check-inactivity';

    protected $description = 'Check ESP32 inactivity and update connection status accordingly';

    public function handle()
    {
        $fiveMinutesAgo = Carbon::now()->subMinutes(1);

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

        $this->info('ESP32 inactivity checked and connection status updated.');
    }
}
