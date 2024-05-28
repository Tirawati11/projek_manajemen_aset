<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::paginate(10); // Menggunakan paginate dengan 10 item per halaman
        return view('lokasi.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:locations,name',
        ]);

        Location::create($validatedData);

        return redirect()->route('lokasi.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $locations)
    {
        return view('lokasi.show', compact('locations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('lokasi.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:locations,name,' . $location->id,
        ]);

        $location->update($validatedData);

        return redirect()->route('lokasi.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $id)
    {

        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus')
            ->with('success', 'Location deleted successfully.');
    }
}
