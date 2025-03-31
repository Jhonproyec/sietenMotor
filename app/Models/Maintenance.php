<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;
    protected $fillable = [
        'mechanic_charge',
        'date_maintenance',
        'date_next_maintenance',
        'status',
        'factura',
        'id_vehicle'
    ];
}
