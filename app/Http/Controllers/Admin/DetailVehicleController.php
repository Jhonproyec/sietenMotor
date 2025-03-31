<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailVehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_vehicle = $request->id;
    
        return view('admin.detail_vehicle.index');
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
