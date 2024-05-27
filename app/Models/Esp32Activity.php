<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ESP32;

class Esp32Activity extends Model
{
    protected $table = 'esp32_activities';

    protected $fillable = [
        'esp32_id', 'created_at', 'updated_at'
    ];

    public function esp32()
    {
        return $this->belongsTo(ESP32::class);
    }
}
