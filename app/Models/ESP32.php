<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Esp32Activity;

class ESP32 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'esp32s'; // Suponiendo que tu tabla se llame 'esp32s'

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'esp32_id', 'ip_address', 'is_connected','created_at', 'update_at',
    ];

    /**
     * Get the activities associated with the ESP32.
     */
    public function activities()
    {
        return $this->hasMany(Esp32Activity::class);
    }
}
