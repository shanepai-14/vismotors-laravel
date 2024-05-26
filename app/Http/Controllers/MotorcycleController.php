<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotorcycleColor;
class MotorcycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motorcyclecolor = MotorcycleColor::all();
        return view('layouts.setup.motor_color.index', [
            'motorcyclecolor' => $motorcyclecolor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.setup.motor_color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required'
        ]);

        MotorcycleColor::create($request->all());

        return redirect()->route('motor_color.index')->with('success', 'Data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($motorcyclecolor)
    {
        $motorcyclecolor = MotorcycleColor::findOrFail($motorcyclecolor);
        return view('layouts.setup.motor_color.create',[
            'motorcyclecolor' => $motorcyclecolor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$motorcyclecolor)
    {
        $motorcyclecolor = MotorcycleColor::findOrFail($motorcyclecolor);
        $request->validate([
            'color' => 'required'
        ]);

        $motorcyclecolor->update($request->all());

        return redirect()->route('motor_color.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
