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
            DB::raw("SUM(CASE WHEN komponen_gajis.satuan = 'bulan' THEN komponen_gajis.nominal ELSE 0 END) as take_home_pay_per_bulan"),
            DB::raw("SUM(CASE WHEN komponen_gajis.satuan = 'periode' THEN komponen_gajis.nominal ELSE 0 END) as take_home_pay_per_periode")
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
                $query->having(function ($having) use ($search) {
                    $having->where('anggotas.id_anggota', 'like', "%{$search}%")
                        ->orWhere('anggotas.nama_depan', 'like', "%{$search}%")
                        ->orWhere('anggotas.nama_belakang', 'like', "%{$search}%")
                        ->orWhere('anggotas.jabatan', 'like', "%{$search}%")
                        ->orWhere(DB::raw("SUM(CASE WHEN komponen_gajis.satuan = 'bulan' THEN komponen_gajis.nominal ELSE 0 END)"), 'like', "%{$search}%")
                        ->orWhere(DB::raw("SUM(CASE WHEN komponen_gajis.satuan = 'periode' THEN komponen_gajis.nominal ELSE 0 END)"), 'like', "%{$search}%");
                });
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
    public function show(Penggajian $penggajian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penggajian $penggajian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penggajian $penggajian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penggajian $penggajian)
    {
        //
    }
}
