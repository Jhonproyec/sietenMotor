<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
            // Obtener el valor de 'perPage' o usar 25 como valor predeterminado
    $perPage = $request->input('perPage', 25);

    $clients = Client::orderBy('id', 'desc')->paginate($perPage);

    $clients->getCollection()->transform(function ($client) {
        $client->created_at = Carbon::parse($client->created_at)->format('d-m-Y');
        return $client;
    });

    return view('admin.clients.index', compact('clients', 'perPage'));
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        
        ]);

        if($request->id_client != null){
            $data['update_at'] = now();
            $client = Client::findOrFail($request->id_client);
            $client->update($data);

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Editado',
                'text' => 'Cliente Editado correctamente'
            ]);

        }else{
            $data['id_user'] = auth()->id();
            $data['created_at'] = now();
            Client::create($data);
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Guardado',
                'text' => 'Cliente Guardado correctamente'
            ]);    

        }    

        return redirect()->route('admin.clientes.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
        
        $client = Client::findOrFail($id);
        $client->delete();

        // $client->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'Cliente eliminado correctamente'
        ]);

        return redirect()->route('admin.clientes.index');
    }

    public function search(Request $request)
    {
        $perPage = $request->input('perPage', 25); 
        $query = $request->input('search');
        $clients = Client::where('name', 'LIKE', "%$query%")
        ->orWhere('lastname', 'LIKE', "%$query%")
        ->orWhere('phone', 'LIKE', "%$query%")
        ->orWhere('email', 'LIKE', "%$query%")
        ->paginate($perPage);

        return view('admin.clients.index', compact('clients', 'perPage'));
        
    }

    public function vehiculos($id){
    
        $perPage = 25;
        $client = Client::findOrFail($id);
        $clients = Client::orderBy('id', 'desc')->get();
        $vehicles = Vehicles::where('id_client', $id)
            ->join('clients', 'vehicles.id_client', '=', 'clients.id')
            ->select(
                'vehicles.*',
                DB::raw("CONCAT(clients.name, ' ', clients.lastname) as client_name"),
                DB::raw("CONCAT(vehicles.brand, ' ', vehicles.model) as brand_model"),
                DB::raw("DATE_FORMAT(vehicles.date_entered, '%d-%m-%Y') as formatted_date")
            )
            ->orderBy('vehicles.id', 'desc')
            ->paginate($perPage);
        
        return view('admin.clients.vehicle_user', compact('vehicles','client', 'clients', 'perPage'));
    }
}
