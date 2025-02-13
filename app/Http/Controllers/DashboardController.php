<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Services\BarangServices;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $barangServices;

    public function __construct(BarangServices $barangServices)
    {
        $this->barangServices = $barangServices;
    }

    public function index()
    {
        $title = 'Dashboard';
        return view('Dashboard.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->barangServices->find($id);
        return view('dashboard.view', compact('model'));
    }

    public function getCountPelanggan()
    {
        $data = Pelanggan::count();
        return response()->json($data);
    }

    public function getCountBarang()
    {
        $data = Barang::count();
        return response()->json($data);
    }

    public function getCountLaporanTransaksi()
    {
        $data = Transaksi::count();
        return response()->json($data);
    }

    public function getBarang()
    {
        $data = Barang::whereColumn('stok', '<=', 'stok_minimal')
            ->get()
            ->map(function ($item) {
                if ($item->stok == 0) {
                    $item->status_stok = 'Stok Habis';
                } else {
                    $item->status_stok = 'Stok Menipis';
                }
                return $item;
            });
        return response()->json($data);
    }

    public function chart()
    {
        DB::statement("SET lc_time_names = 'id_ID'");

        $data = Transaksi::select(
            DB::raw("DATE_FORMAT(created_at, '%W') as hari"),
            DB::raw("SUM(total_akhir) as total")
        )
            ->groupBy('hari')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();


        return response()->json($data);
    }
}
