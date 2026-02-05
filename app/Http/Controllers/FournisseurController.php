<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();

        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fournisseurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|string',
        ]);
        Fournisseur::create($data);

        return redirect()->route('admin.fournisseurs.index')->with('success', 'Fournisseur created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        return view('admin.fournisseurs.edit', compact('fournisseur'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'email' => 'required|string',
        ]);

        $fournisseur->update($data);

        return redirect()->route('admin.fournisseurs.index')->with('success', 'Fournisseur updated successfully!');
    }

    public function archive(Request $request){
        $fournisseurs_archives = Fournisseur::onlyTrashed()->get();
        return view('admin.fournisseurs.archive',compact('fournisseurs_archives'));
    }
    public function trash(string $id){
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();        
        return redirect()->route('admin.fournisseurs.index');
    }
    public function restore(string $id){
        Fournisseur::onlyTrashed()->where('id',$id)->restore();
        return redirect()->route('admin.fournisseurs.archive');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // hnaya kanjibo ga3 les fournisseur m3a dok li deleted_at machi null o li id dyalo kaysssawi li jay flparametre
        $fournisseur = Fournisseur::withTrashed()->findOrFail($id);
        // o kandiro lih force delete 7it delete 3adiya ghadi ghir diro flarchive 7it sste3melt use softedelete fl models
        $fournisseur->forceDelete();
        return redirect()->route('admin.fournisseurs.index')->with('success', 'Fournisseur deleted successfully!');
    }
}
