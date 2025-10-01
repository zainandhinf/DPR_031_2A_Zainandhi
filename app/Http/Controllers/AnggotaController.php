<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Anggota::all();
        return view(
            'pages.anggota',
            [
                'title' => 'Anggota',
                'items' => $items,
            ]
        );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'pages.create',
            [
                'title' => 'Anggota',
            ]
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_depan' => 'required|max:100',
            'nama_belakang' => 'required|max:100',
            'gelar_depan' => 'required|max:50',
            'gelar_belakang' => 'required|max:50',
            'jabatan' => 'required',
            'status_pernikahan' => 'required',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggotas.index')->with('success', 'Data added successfully!!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        return view('pages.view', [
            'title' => 'Detail Anggota',
            'item' => $anggota
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        return view('pages.edit', [
            'title' => 'Anggota',
            'item' => $anggota
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama_depan' => 'required|max:100',
            'nama_belakang' => 'required|max:100',
            'gelar_depan' => 'required|max:50',
            'gelar_belakang' => 'required|max:50',
            'jabatan' => 'required',
            'status_pernikahan' => 'required',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggotas.index')->with('success', 'Data updated successfully!!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()->route('anggotas.index')->with('success', 'Course successfully deleted!!');
    }
}
