<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiempoMesa extends Model
{
    use HasFactory;

    protected $fillable = ['mesa_id', 'billar','pagado', 'duracion'];
    protected $table = 'tiempo_mesas'; // Nombre de la tabla en la base de datos


    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    // Otros métodos o atributos relacionados con el tiempo de las mesas
}
