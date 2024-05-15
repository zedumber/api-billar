<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Mesa extends Model
{
    protected $fillable = ['nombre']; // Campos que se pueden modificar
    protected $table = 'mesas'; // Nombre de la tabla en la base de datos
    public function tiempo()
    {
        return $this->hasOne(TiempoMesa::class);
        return $this->hasMany(TiempoMesa::class);
    }


    use HasFactory;
}
