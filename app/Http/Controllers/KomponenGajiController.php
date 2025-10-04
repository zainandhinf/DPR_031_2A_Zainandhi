<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $items = KomponenGaji::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_komponen', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nominal', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%")
                    ->orWhere('id_komponen_gaji', 'like', "%{$search}%");
            })
            ->get();

        return view('pages.komponengaji', [
            'title' => 'Komponen Gaji',
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastId = KomponenGaji::orderBy('id_komponen_gaji', 'desc')->value('id_komponen_gaji');

        $nextId = $lastId ? $lastId + 1 : 1;
        return view(
            'pages.create',
            [
                'title' => 'Komponen Gaji',
                'nextId' => $nextId
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_komponen_gaji' => 'required|max:20|unique:komponen_gajis,id_komponen_gaji',
            'nama_komponen' => 'required|max:100',
            'kategori' => 'required',
            'jabatan' => 'required',
            'nominal' => 'required|numeric',
            'satuan' => 'required',
        ]);

        KomponenGaji::create($validated);

        return redirect()->route('komponen_gajis.index')->with('success', 'Data added successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomponenGaji $komponenGaji)
    {
        return view('pages.view', [
            'title' => 'Detail Komponen Gaji',
            'item' => $komponenGaji
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomponenGaji $komponenGaji)
    {
        return view('pages.edit', [
            'title' => 'Komponen Gaji',
            'item' => $komponenGaji
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomponenGaji $komponenGaji)
    {
        $validated = $request->validate([
            'nama_komponen' => 'required|max:100',
            'kategori' => 'required',
            'jabatan' => 'required',
            'nominal' => 'required|numeric',
            'satuan' => 'required',
        ]);

        $komponenGaji->update($validated);

        return redirect()->route('komponen_gajis.index')->with('success', 'Data updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomponenGaji $komponenGaji)
    {
        $komponenGaji->delete();

        return redirect()->route('komponen_gajis.index')->with('success', 'Data successfully deleted!!');
    }
}
