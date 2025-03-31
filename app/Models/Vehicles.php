<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    /** @use HasFactory<\Database\Factories\VehiclesFactory> */
    use HasFactory;
    protected $fillable = [
        'brand',              // Marca del vehículo
        'model',                  // Modelo del vehículo
        'year',    // Año del vehículo (actual)
        'registration', // Registro del vehículo (aleatorio)
        'vin', // VIN aleatorio
        'no_chasis', // Número de chasis aleatorio
        'no_motor', // Número de motor aleatorio
        'fuel_type', // Tipo de combustible
        'id_client',               // Asigna un cliente aleatorio
        'id_user',
    ];
}
