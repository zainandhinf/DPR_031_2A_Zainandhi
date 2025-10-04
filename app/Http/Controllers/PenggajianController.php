<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\KomponenGaji;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $items = Penggajian::select(
            'anggotas.id_anggota',
            'anggotas.gelar_depan',
            'anggotas.nama_depan',
            'anggotas.nama_belakang',
            'anggotas.gelar_belakang',
            'anggotas.jabatan',
            DB::raw("SUM(
        CASE 
            WHEN komponen_gajis.satuan = 'bulan' THEN 
                komponen_gajis.nominal * CASE WHEN anggotas.jml_anak > 0 THEN LEAST(anggotas.jml_anak, 2) ELSE 1 END
            ELSE 0
        END
    ) as take_home_pay_per_bulan"),
            DB::raw("SUM(
        CASE 
            WHEN komponen_gajis.satuan = 'periode' THEN komponen_gajis.nominal
            ELSE 0
        END
    ) as take_home_pay_per_periode")
        )
            ->join('anggotas', 'penggajians.id_anggota', '=', 'anggotas.id_anggota')
            ->join('komponen_gajis', 'penggajians.id_komponen_gaji', '=', 'komponen_gajis.id_komponen_gaji')
            ->groupBy(
                'anggotas.id_anggota',
                'anggotas.gelar_depan',
                'anggotas.nama_depan',
                'anggotas.nama_belakang',
                'anggotas.gelar_belakang',
                'anggotas.jabatan'
            )
            ->when($search, function ($query, $search) {
                $query->havingRaw("anggotas.id_anggota LIKE ?", ["%{$search}%"])
                    ->orHavingRaw("anggotas.nama_depan LIKE ?", ["%{$search}%"])
                    ->orHavingRaw("anggotas.nama_belakang LIKE ?", ["%{$search}%"])
                    ->orHavingRaw("anggotas.jabatan LIKE ?", ["%{$search}%"])
                    ->orHavingRaw("SUM(
                CASE 
                    WHEN komponen_gajis.satuan = 'bulan' THEN 
                        komponen_gajis.nominal * CASE WHEN anggotas.jml_anak > 0 THEN LEAST(anggotas.jml_anak, 2) ELSE 1 END
                    ELSE 0
                END
            ) LIKE ?", ["%{$search}%"])
                    ->orHavingRaw("SUM(
                CASE 
                    WHEN komponen_gajis.satuan = 'periode' THEN komponen_gajis.nominal
                    ELSE 0
                END
            ) LIKE ?", ["%{$search}%"]);
            })
            ->get();


        return view('pages.penggajian', [
            'title' => 'Penggajian',
            'items' => $items,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotas = Anggota::all();

        return view(
            'pages.create',
            [
                'title' => 'Penggajian',
                'anggotas' => $anggotas,
            ]
        );
    }

    // Fungsi mengambil komponen sesuai jabatan, status pernikahan, dan jumlah anak jika lebih dari 0 
    public function getKomponen($id_anggota)
    {
        // Ambil data anggota
        $anggota = Anggota::find($id_anggota);

        if (!$anggota) {
            return response()->json([]);
        }

        // Ambil jabatan dari anggota
        $jabatan = $anggota->jabatan;

        // Ambil semua komponen berdasarkan jabatan
        $komponenGajis = KomponenGaji::where('jabatan', $jabatan)
            ->orWhere('jabatan', 'semua')
            ->get();

        // Filter tambahan: berdasarkan status kawin dan anak
        $filtered = $komponenGajis->filter(function ($k) use ($anggota) {
            $nama = strtolower($k->nama_komponen);

            // Jika status belum kawin maka hilangkan tunjangan istri/suami dan tunjangan anak
            if ($anggota->status_pernikahan != 'kawin' && (
                str_contains($nama, 'tunjangan istri/suami') ||
                str_contains($nama, 'tunjangan anak')
            )) {
                return false;
            }

            // Jika status kawin tapi anak 0 maka hilangkan tunjangan anak
            if (
                $anggota->status_pernikahan == 'kawin' &&
                $anggota->jml_anak == 0 &&
                str_contains($nama, 'tunjangan anak')
            ) {
                return false;
            }

            return true;
        });

        return response()->json($filtered->values());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required',
            'id_komponen_gaji' => [
                'required',
                Rule::unique('penggajians')->where(function ($query) use ($request) {
                    return $query->where('id_anggota', $request->id_anggota);
                }),
            ],
        ], [
            'id_komponen_gaji.unique' => 'This salary component has already been added for that member..',
        ]);

        Penggajian::create($validated);

        return redirect()->route('penggajians.index')->with('success', 'Data added successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_anggota)
    {
        $anggota = Anggota::where('id_anggota', $id_anggota)->firstOrFail();

        $komponenGaji = Penggajian::join('komponen_gajis', 'penggajians.id_komponen_gaji', '=', 'komponen_gajis.id_komponen_gaji')
            ->join('anggotas', 'penggajians.id_anggota', '=', 'anggotas.id_anggota')
            ->where('penggajians.id_anggota', $id_anggota)
            ->select(
                'penggajians.id_komponen_gaji',
                'komponen_gajis.nama_komponen',
                DB::raw('CASE 
                    WHEN anggotas.jml_anak > 0 THEN komponen_gajis.nominal * LEAST(anggotas.jml_anak, 2)
                    ELSE komponen_gajis.nominal
                END as nominal'),
                'komponen_gajis.satuan'
            )
            ->get();

        $totalBulanan = $komponenGaji->where('satuan', 'bulan')->sum('nominal');
        $totalPeriode = $komponenGaji->where('satuan', 'periode')->sum('nominal');

        return view('pages.view', [
            'title' => 'Detail Penggajian',
            'anggota' => $anggota,
            'komponenGaji' => $komponenGaji,
            'totalBulanan' => $totalBulanan,
            'totalPeriode' => $totalPeriode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_anggota, $id_komponen_gaji)
    {
        $item = Penggajian::join('komponen_gajis', 'komponen_gajis.id_komponen_gaji', '=', 'penggajians.id_komponen_gaji')
            ->join('anggotas', 'anggotas.id_anggota', '=', 'penggajians.id_anggota')
            ->where('penggajians.id_anggota', $id_anggota)
            ->where('komponen_gajis.id_komponen_gaji', $id_komponen_gaji)
            ->select(
                'penggajians.id_anggota',
                'penggajians.id_komponen_gaji',
                'komponen_gajis.nama_komponen',
                'komponen_gajis.nominal',
                'komponen_gajis.satuan'
            )
            ->firstOrFail();

        return view('pages.edit', [
            'title' => 'Penggajian',
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_anggota, $id_komponen_gaji_lama)
    {
        $validated = $request->validate([
            'id_komponen_gaji' => [
                'required',
                Rule::unique('penggajians')->where(function ($query) use ($id_anggota) {
                    return $query->where('id_anggota', $id_anggota);
                })->ignore($id_komponen_gaji_lama, 'id_komponen_gaji'),
            ],
        ], [
            'id_komponen_gaji.unique' => 'Komponen gaji ini sudah terdaftar untuk anggota tersebut.',
        ]);

        Penggajian::where('id_anggota', $id_anggota)
            ->where('id_komponen_gaji', $id_komponen_gaji_lama)
            ->update([
                'id_komponen_gaji' => $validated['id_komponen_gaji']
            ]);

        return redirect()->route('penggajians.show', $id_anggota)->with('success', 'Data updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_anggota, $id_komponen_gaji)
    {
        Penggajian::where('id_anggota', $id_anggota)
            ->where('id_komponen_gaji', $id_komponen_gaji)
            ->delete();

        return redirect()->route('penggajians.show', $id_anggota)->with('success', 'Data successfully deleted!!');
    }
}
