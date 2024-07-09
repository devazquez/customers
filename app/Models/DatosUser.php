<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosUser extends Model
{
    use HasFactory;
    //indicamos la tabla de la base de datos asociada al modelo DatosUser
    protected $table = "datosusers";

    protected $fillable = [
        'user_id',  'edificio_id', 'area_id', 'nombres', 'apellido1', 'apellido2', 'sexo', 'nacimiento',  'alcaldia', 'entidad_federativa',
        'numero_trabajador', 'personas_casa', 'gas_casa', 'pago_luz', 'pago_gas','distancia'
    ];

    //public $timestamps = false;
}
