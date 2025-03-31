<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.maintenance.index');
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

        $request->validate([
            'mechanic_charge' => 'nullable|string',
            'date_maintenance' => 'nullable|date',
            'date_next_maintenance' => 'nullable|date',
            'status' => 'nullable|string',
            'factura' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        if ($request->id_maintenance == null) {
            $maintenance = Maintenance::create([
                'mechanic_charge' => $request->mechanic_charge,
                'date_maintenance' => $request->date_maintenance,
                'date_next_maintenance' => $request->date_next_maintenance,
                'status' => $request->status,
                'factura' => null,
                'id_vehicle' => $request->id_vehicle
            ]);
        } else {
            // Actualizar el registro existente
            $maintenance = Maintenance::find($request->id_maintenance); // Buscar el registro
            $maintenance->update([
                'mechanic_charge' => $request->mechanic_charge,
                'date_maintenance' => $request->date_maintenance,
                'date_next_maintenance' => $request->date_next_maintenance,
                'status' => $request->status,
            ]);
        }

        if ($request->hasFile('factura')) {
            $file = $request->file('factura');
        
            if ($maintenance->factura) {
                $oldFilePath = str_replace('storage/', 'public/', $maintenance->factura);
                Storage::delete($oldFilePath); // Usa Storage para borrar el archivo
            }
        
            $fileName = 'factura_' . $maintenance->id . '.' . $file->getClientOriginalExtension();
        
            $filePath = $file->storeAs('public/facturas', $fileName);
        
            $maintenance->update(['factura' => str_replace('public/', 'storage/', $filePath)]);
        }

        $vehicle = Vehicles::select('vehicles.*',
            DB::raw("CONCAT(clients.name, ' ', clients.lastname) as owner_full_name"),
            DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model, ' ', vehicles.year) as info_car     ")
        )
        ->join('clients', 'clients.id', '=', 'vehicles.id_client')
        ->where('vehicles.id', $request->id_vehicle)
        ->firstOrFail();

        $maintenances = Maintenance::where('id_vehicle', $request->id_vehicle)
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.detail_vehicle.index', [
            'vehicle' => $vehicle,
            'maintenances' => $maintenances,
            'tab' => 'tab2' // Activar la pestaña de mantenimiento
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        if ($maintenance->factura) {
            $oldFilePath = str_replace('storage/', 'public/', $maintenance->factura);
            Storage::delete($oldFilePath); // Usa Storage para borrar el archivo
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'Cliente eliminado correctamente'
        ]);


        $vehicle = Vehicles::select('vehicles.*',
            DB::raw("CONCAT(clients.name, ' ', clients.lastname) as owner_full_name"),
            DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model, ' ', vehicles.year) as info_car     ")
        )
        ->join('clients', 'clients.id', '=', 'vehicles.id_client')
        ->where('vehicles.id', $maintenance->id_vehicle)
        ->firstOrFail();

        $maintenances = Maintenance::where('id_vehicle', $maintenance->id_vehicle)
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.detail_vehicle.index', [
            'vehicle' => $vehicle,
            'maintenances' => $maintenances,
            'tab' => 'tab2' // Activar la pestaña de mantenimiento
        ]);



    }
}
