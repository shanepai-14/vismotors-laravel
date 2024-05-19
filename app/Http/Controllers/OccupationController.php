<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    public function index()
    {
        $occupations = Occupation::all();
        return view('layouts.setup.occupation.index', [
            'occupations' => $occupations
        ]);
    }

    public function create()
    {
        return view('layouts.setup.occupation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Occupation::create($request->all());

        return redirect()->route('occupation.index')->with('success', 'Data saved successfully');
    }

    public function show(Occupation $occupation)
    {
        //
    }

    public function edit(Occupation $occupation)
    {
        return view('layouts.setup.occupation.create',[
            'occupation' => $occupation
        ]);
    }

    public function update(Request $request, Occupation $occupation)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $occupation->update($request->all());

        return redirect()->route('occupation.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Occupation $occupation)
    {
        //
    }
}
