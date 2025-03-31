<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehicles;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $clients = Client::all();
        $vehicles = Vehicles::join('clients', 'vehicles.id_client', '=', 'clients.id')
            ->select(
                'vehicles.*',
                DB::raw("CONCAT(clients.name, ' ', clients.lastname) as client_name"),
                DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model) as brand_model")
            )
            ->orderBy('vehicles.id', 'desc')
            ->paginate($perPage);

        // return $vehicles;
        return view('admin.vehicles.index', compact('vehicles', 'clients', 'perPage'));
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
        // Validación de datos
        $data = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|numeric',
            'registration' => 'required|string|max:255',
            'vin' => 'nullable|string|max:255',
            'no_chasis' => 'nullable|string|max:255',
            'no_motor' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'id_client' => 'nullable|required|numeric',
        ]);

        if ($request->id_vehicle === null) {
            $data['id_user'] = auth()->id();
            $data['created_at'] = now();
            // Crear el vehículo usando el modelo
            Vehicles::create($data);

            // Mostrar mensaje de éxito
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Guardado',
                'text' => 'Vehículo Guardado correctamente'
            ]);
        } else {
            $data['update_at'] = now();
            $vehicle = Vehicles::findOrFail($request->id_vehicle);
            $vehicle->update($data);
            // Mostrar mensaje de éxito
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Editado',
                'text' => 'Vehículo Editado correctamente'
            ]);
        }



        // return $request;
        return redirect()->route('admin.vehiculos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicles $vehicles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicles $vehicles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicles $vehicles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $vehicle->delete();

        
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'Vehículo eliminado correctamente'
        ]);

        return redirect()->route('admin.vehiculos.index');
    }
 
    public function search(Request $request)
    {
        $perPage = $request->input('perPage', 25); 
        $searchTerm = $request->input('search'); // Evitar sombra en la variable
        $clients = Client::all();
        $vehicles = Vehicles::join('clients', 'vehicles.id_client', '=', 'clients.id')
            ->where(function ($query) use ($searchTerm) { // Usamos $searchTerm en lugar de $query
                $query->where('vehicles.brand', 'like', "%$searchTerm%")
                    ->orWhere('vehicles.model', 'like', "%$searchTerm%")
                    ->orWhere('vehicles.year', 'like', "%$searchTerm%")
                    ->orWhere('vehicles.registration', 'like', "%$searchTerm%")
                    ->orWhere('vehicles.fuel_type', 'like', "%$searchTerm%")
                    ->orWhere(DB::raw("CONCAT(clients.name, ' ', clients.lastname)"), 'like', "%$searchTerm%");
            })
            ->select(
                'vehicles.*',
                DB::raw("CONCAT(clients.name, ' ', clients.lastname) as client_name"),
                DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model) as brand_model")
            )
            ->orderBy('vehicles.id', 'desc')
            ->paginate($perPage); // Agregar la cantidad de elementos por página
            // return $vehicles;
            return view('admin.vehicles.index', compact('vehicles', 'clients'));
    }
    

}
