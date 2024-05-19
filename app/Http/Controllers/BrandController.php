<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('layouts.setup.brand.index', [
            'brands' => $brands
        ]);
    }

    public function create()
    {
        return view('layouts.setup.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Brand::create($request->all());

        return redirect()->route('brand.index')->with('success', 'Data saved successfully');
    }

    public function show(Brand $brand)
    {
        //
    }

    public function edit(Brand $brand)
    {
        return view('layouts.setup.brand.create',[
            'brand' => $brand
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $brand->update($request->all());

        return redirect()->route('brand.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Brand $brand)
    {
        //
    }
}
