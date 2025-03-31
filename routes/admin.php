<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DetailVehicleController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\VehiclesController;
use Illuminate\Support\Facades\Route;

Route::resource('clientes', ClientController::class);
Route::resource('vehiculos', VehiclesController::class);
Route::resource('detalles-vehiculo', DetailVehicleController::class);
Route::resource('mantenimiento', MaintenanceController::class);
