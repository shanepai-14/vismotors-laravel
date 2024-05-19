<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $motors = Motor::all();

        return view('layouts.setup.motor.index',[
            'motors' => $motors
        ]);
    }

    public function create()
    {
        $brands = Brand::all();
        return view('layouts.setup.motor.create',[
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'model_name' => 'required',
            'model_year' => 'required',
            'specifications' => 'required'
        ]);

        Motor::create($request->all());

        return redirect()->route('motor.index')->with('success', 'Data saved successfully');
    }

    public function show(Motor $motor)
    {
        //
    }

    public function edit(Motor $motor)
    {
        $brands = Brand::all();
        return view('layouts.setup.motor.create',[
            'brands' => $brands,
            'motor' => $motor
        ]);
    }

    public function update(Request $request, Motor $motor)
    {
        $request->validate([
            'brand_id' => 'required',
            'model_name' => 'required',
            'model_year' => 'required',
            'specifications' => 'required'
        ]);

        $motor->update($request->all());

        return redirect()->route('motor.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Motor $motor)
    {
        //
    }
}
