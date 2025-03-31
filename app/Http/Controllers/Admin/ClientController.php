<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
            // Obtener el valor de 'perPage' o usar 25 como valor predeterminado
    $perPage = $request->input('perPage', 25);

    // Obtener los clientes con paginación
    $clients = Client::paginate($perPage);

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
}
