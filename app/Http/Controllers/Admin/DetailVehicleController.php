<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailVehicle;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_vehicle = $request->id;


        $vehicle = Vehicles::select('vehicles.*',
            DB::raw("CONCAT(clients.name, ' ', clients.lastname) as owner_full_name"),
            DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model, ' ', vehicles.year) as info_car"),
            DB::raw("DATE_FORMAT(vehicles.date_entered, '%d-%m-%Y') as formatted_date")
        )
        ->join('clients', 'clients.id', '=', 'vehicles.id_client')
        ->where('vehicles.id', $id_vehicle)
        ->firstOrFail();


        $maintenances = Maintenance::where('id_vehicle', $id_vehicle)
        ->select(
            '*',
            DB::raw("DATE_FORMAT(date_maintenance, '%d-%m-%Y') as formatted_date_maintenance"),
            DB::raw("DATE_FORMAT(date_next_maintenance, '%d-%m-%Y') as formatted_date_next_maintenance")
        )
        ->orderBy('id', 'desc')
        ->get();
    
        $tap = 1;
        
        return view('admin.detail_vehicle.index', [
            'vehicle' => $vehicle,
            'maintenances' => $maintenances,
            'tab' => 'tab1' // Activar la pestaña de mantenimiento
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailVehicle $detailVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailVehicle $detailVehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailVehicle $detailVehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailVehicle $detailVehicle)
    {
        //
    }
}
