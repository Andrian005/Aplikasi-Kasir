<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Exports\LaporanBarangExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanBarangController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Laporan Barang';

        $model = Barang::with(['kategori', 'detailTransaksi', 'tambahStok']);

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
                ->addColumn('stok_awal', function ($stok) {
                    return $stok->stok_awal;
                })
                ->addColumn('role', function () {
                    return auth()->user()->role->role;
                })
                ->addColumn('total_stok', function ($row) {
                    return $row->total_stok;
                })
                ->make(true);
        }

        return view('report.laporan-barang.index', compact('title'));
    }

    public function view($id)
    {
        $model = Barang::with('detailTransaksi')->findOrFail($id);
        return view('report.laporan-barang.view', compact('model'));
    }

    public function excel(Request $request)
    {
        $dateRange = $request->get('date_range');

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            $dateRange = $dates;
        }

        $filename = 'laporan-barang.xlsx';

        activity()
            ->useLog('Laporan Barang')
            ->performedOn(new Barang)
            ->causedBy(Auth::user())
            ->event('export')
            ->withProperties([
                'filename' => $filename,
                'jumlah_data' => Barang::count(),
            ])
            ->log('Export Laporan Barang Excel');

        return Excel::download(new LaporanBarangExport($dateRange), $filename);
    }

    public function pdf(Request $request)
    {
        $dateRangeInput = $request->get('date_range');
        $query = Barang::with(['kategori', 'detailTransaksi', 'tambahStok']);

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
        $barang = $query->get();
        $filename = 'laporan-barang.pdf';

        activity()
            ->useLog('Laporan Barang')
            ->performedOn(new Barang)
            ->causedBy(Auth::user())
            ->event('export')
            ->withProperties([
                'filename' => $filename,
                'jumlah_data' => $barang->count(),
            ])
            ->log('Export Laporan Barang PDF');

        $pdf = PDF::loadView('report.laporan-barang.pdf', compact('barang', 'dateRange'));
        return $pdf->download($filename);
    }
}
