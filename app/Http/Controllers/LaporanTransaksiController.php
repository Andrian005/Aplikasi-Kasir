<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;
use Yajra\DataTables\Facades\DataTables;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Laporan Transaksi';
        $model = Transaksi::with(['detailTransaksi', 'pelanggan.typePelanggan']);

        if ($request->has('date_range') && !empty($request->date_range)) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $model->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($request->ajax()) {
            return DataTables::of($model)
                ->addColumn('role', function () {
                    return auth()->user()->role->role;
                })->make(true);
        }

        return view('laporan-transaksi.index', compact('title'));
    }

    public function view($id)
    {
        $model = Transaksi::with(['detailTransaksi', 'pelanggan', 'typePelanggan'])->findOrFail($id);
        return view('laporan-transaksi.view', compact('model'));
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {

            $transaksi = Transaksi::findOrFail($id);
            $transaksi->detailTransaksi()->delete();
            $transaksi->delete();

            DB::commit();
            return [
                'message' => 'Laporan Transaksi Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Laporan Transaksi Gagal di Delete',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function excel(Request $request)
    {
        $dateRange = $request->get('date_range');

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            $dateRange = $dates;
        }

        return Excel::download(new LaporanTransaksiExport($dateRange), 'laporan-transaksi.xlsx');
    }

    public function pdf(Request $request)
    {
        $dateRangeInput = $request->get('date_range');
        $query = Transaksi::with(['detailTransaksi', 'pelanggan', 'typePelanggan']);

        $dateRange = null;
        if ($dateRangeInput) {
            $dates = explode(' - ', $dateRangeInput);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$startDate, $endDate]);
                $dateRange = [$startDate, $endDate];
            }
        }
        $transaksis = $query->get();

        $pdf = PDF::loadView('laporan-transaksi.pdf', compact('transaksis', 'dateRange'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
