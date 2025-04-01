<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
            'factura' => 'nullable|file|mimes:pdf|max:2048',
            'description_maintenance' => 'required|string'
        ]);

        if ($request->id_maintenance == null) {
            $maintenance = Maintenance::create([
                'mechanic_charge' => $request->mechanic_charge,
                'date_maintenance' => $request->date_maintenance,
                'date_next_maintenance' => $request->date_next_maintenance,
                'status' => $request->status,
                'factura' => null,
                'id_vehicle' => $request->id_vehicle,
                'description_maintenance' => $request->description_maintenance
            ]);
        } else {
            // Actualizar el registro existente
            $maintenance = Maintenance::find($request->id_maintenance); // Buscar el registro
            $maintenance->update([
                'mechanic_charge' => $request->mechanic_charge,
                'date_maintenance' => $request->date_maintenance,
                'date_next_maintenance' => $request->date_next_maintenance,
                'status' => $request->status,
                'description_maintenance' => $request->description_maintenance,
            ]);
        }

        if ($request->hasFile('factura')) {
            $file = $request->file('factura');
        
            // Si el mantenimiento ya tiene una factura, eliminar el archivo anterior
            if ($maintenance->factura) {
                $oldFilePath = str_replace('storage/', 'public/', $maintenance->factura);
                Storage::delete($oldFilePath); // Usa Storage para borrar el archivo
            }
        
            // Generar el nombre del archivo usando el ID del mantenimiento
            $fileName = 'factura_' . $maintenance->id . '.' . $file->getClientOriginalExtension();
        
            // Guardar el archivo en la carpeta 'public/facturas'
            $file->storeAs('public/facturas', $fileName);
        
            // Actualizar solo el nombre del archivo en la base de datos
            $maintenance->update(['factura' => 'facturas/' . $fileName]);
        }

        $vehicle = Vehicles::select(
            'vehicles.*',
            DB::raw("CONCAT(clients.name, ' ', clients.lastname) as owner_full_name"),
            DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model, ' ', vehicles.year) as info_car"),
            DB::raw("DATE_FORMAT(vehicles.date_entered, '%d-%m-%Y') as formatted_date")
        )
            ->join('clients', 'clients.id', '=', 'vehicles.id_client')
            ->where('vehicles.id', $maintenance->id)
            ->firstOrFail();


        $maintenances = Maintenance::where('id_vehicle', $maintenance->id)
            ->select(
                '*',
                DB::raw("DATE_FORMAT(date_maintenance, '%d-%m-%Y') as formatted_date_maintenance"),
                DB::raw("DATE_FORMAT(date_next_maintenance, '%d-%m-%Y') as formatted_date_next_maintenance")
            )
            ->orderBy('id', 'desc')
            ->get();

        $tap = 2;

        return redirect()->back();
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
            'text' => 'Mantenimiento eliminado correctamente'
        ]);


        $vehicle = Vehicles::select(
            'vehicles.*',
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

    public function downloadPDF($path)
    {
        $path = storage_path('app/private/public/facturas/' . $path);
        if(!file_exists($path)){
            return "Estsis";
        }

        return response()->download($path);
    }
}