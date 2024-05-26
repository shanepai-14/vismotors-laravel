<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\MotorColorKey;
use App\Models\MotorType;
use App\Models\MotorcycleColor;
use Illuminate\Http\Request;

class MotorColorKeyController extends Controller
{
    public function index(Motor $motor)
    {
        $color_keys = MotorColorKey::where('motor_id', $motor->id)->get();

        return view('layouts.setup.motor.color.index', [
            'motor' => $motor,
            'color_keys' => $color_keys
        ]);
    }

    public function create(Motor $motor)
    {
        $types = MotorType::all();
        $existingColors = $motor->colors()->pluck('color')->toArray();
        $availableColors = MotorcycleColor::whereNotIn('color', $existingColors)->get();
        return view('layouts.setup.motor.color.create', [
            'motor' => $motor,
            'types' => $types,
            'motor_colors' => $availableColors,
        ]);
    }

    public function store(Request $request, Motor $motor)
    {
        $request->validate([
            'color' => 'required',
            'quantity' => 'required',
            'price_cash' => 'required',
            'price_installment' => 'required',
            'interest_rate' => 'required',
        ]);
        $request['motor_id'] = $motor->id;

        MotorColorKey::create($request->all());

        return redirect()->route('color.index', ['motor' => $motor->id])->with('success', 'Data saved successfully');
    }

    public function show(Motor $motor, MotorColorKey $color)
    {
        //
    }

    public function edit(Motor $motor, MotorColorKey $color)
    {
        $types = MotorType::all();
        $existingColors = $motor->colors()->pluck('color')->toArray();
        $currentColor = $color->color;
        $existingColors = array_diff($existingColors, [$currentColor]);
        $availableColors = MotorcycleColor::whereNotIn('color', $existingColors)->get();
        return view('layouts.setup.motor.color.create', [
            'motor' => $motor,
            'motor_colors' => $availableColors,
            'types' => $types,
            'color' => $color,
        ]);
    }

    public function update(Request $request, Motor $motor, MotorColorKey $color)
    {
        $request->validate([
            'color' => 'required',
            'quantity' => 'required',
            'price_cash' => 'required',
            'price_installment' => 'required',
            'interest_rate' => 'required',
            // 'motor_type_id' => 'required'
        ]);
        $request['motor_id'] = $motor->id;

        $color->update($request->all());

        return redirect()->route('color.index', ['motor' => $motor->id])->with('success', 'Data saved successfully');
    }
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'color_id' => 'required',
            'quantity' => 'required',
            'motor_id' => 'required',
        ]);
        $color = MotorColorKey::find($request->color_id);
        $currentQuantity = $color->quantity;
        $color->quantity = $currentQuantity + $request->quantity;
        $color->save();

        return redirect()->route('color.index', ['motor' =>$request->motor_id])->with('success', 'Data saved successfully');
    }
    public function destroy(Motor $motor, MotorColorKey $color)
    {
        //
    }
}
