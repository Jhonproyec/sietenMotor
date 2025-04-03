<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DetailVehicleController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Route;

Route::resource('clientes', ClientController::class);
Route::get('clientes/vehiculos/{id}', [ClientController::class, 'vehiculos'])->name('clientes.vehiculos');



Route::resource('vehiculos', VehiclesController::class);
// Route::resource('detalles-vehiculo', DetailVehicleController::class);
Route::resource('mantenimiento', MaintenanceController::class);
Route::get('mantenimiento/downloadPDF/{filename}', [MaintenanceController::class, 'downloadPDF'])->name('mantenimiento.downloadPDF');
Route::get('vehiculos/detalles_vehiculo/{id}', [VehiclesController::class, 'detalles_vehiculo'])->name('vehiculos.detalles_vehiculo');
