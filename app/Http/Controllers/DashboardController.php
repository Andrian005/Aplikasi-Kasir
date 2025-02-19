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
        return response()->json(
            Barang::with('tambahStok')
                ->where('tgl_kadaluarsa', '>=', now())
                ->get()
                ->map(function ($item) {
                    $item->total_stok = $item->stok + $item->tambahStok->sum('jumlah_stok');
                    $item->status_stok = $item->total_stok == 0 ? 'Stok Habis' : 'Stok Menipis';
                    return $item;
                })
                ->filter(fn($item) => $item->total_stok <= $item->stok_minimal)
                ->values()
        );
    }

    public function chart()
    {
        DB::statement("SET lc_time_names = 'id_ID'");

        $data = Transaksi::select(
            DB::raw("DATE_FORMAT(created_at, '%W') as hari"),
            DB::raw("DATE(created_at) as tanggal"),
            DB::raw("SUM(total_akhir) as total")
        )
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('tanggal', 'hari')
            ->orderBy('tanggal', 'ASC')
            ->get();


        return response()->json($data);
    }
}
