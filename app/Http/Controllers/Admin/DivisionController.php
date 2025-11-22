<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Service;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::paginate(10);
        return view('RH.divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('RH.divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomFr' => 'required|string|max:255',
            'nomAr' => 'required|string|max:255'
        ]);
        
        $division=new Division();
        $division->nomFr=$request->input('nomFr');
        $division->nomAr=$request->input('nomAr');
        $division->save();
        return redirect()->route('division.index')->with('success', 'Division ajouté avec succès.');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // $division=Division::find($id);
        //return view('RH.divisions.edit',compact('division'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomFr' => 'required|string|max:255',
            'nomAr' => 'required|string|max:255'
        ]);
        $division = Division::findOrFail($id);
        
        $division->nomFr=$request->input('nomFr');
        $division->nomAr=$request->input('nomAr');
        $division->save();
        return redirect()->route('division.index')->with('success', 'Division modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // Find the division by ID
        $division = Division::findOrFail($id);
        $division->services()->delete();
        $division->users()->delete();
        // Delete the division
        $division->delete();

        return redirect()->route('division.index')->with('success', 'La division et ses services sont supprimées avec succées.');

    }
}
