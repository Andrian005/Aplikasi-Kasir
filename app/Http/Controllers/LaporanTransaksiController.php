<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;
use Yajra\DataTables\Facades\DataTables;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Laporan Transaksi';

        $user = Auth::user();
        $model = Transaksi::with(['detailTransaksi', 'pelanggan.typePelanggan', 'detailKasir'])
            ->filterByUserRole($user);

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
                })
                ->addColumn('nama_kasir', function ($row) {
                    return $row->detailKasir->name ?? '-';
                })
                ->make(true);
        }

        return view('report.laporan-transaksi.index', compact('title'));
    }

    public function view($id)
    {
        $title = 'Detail Transaksi';
        $model = Transaksi::with(['detailTransaksi', 'pelanggan', 'typePelanggan', 'detailKasir'])->findOrFail($id);
        $detailTransaksi = $model->detailTransaksi()->paginate(5);

        return view('report.laporan-transaksi.view', compact('model', 'title', 'detailTransaksi'));
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

        $filename = 'laporan-transaksi.xlsx';

        activity()
            ->useLog('Laporan Transaksi')
            ->performedOn(new Transaksi)
            ->causedBy(Auth::user())
            ->event('export')
            ->withProperties([
                'date_range' => $dateRange,
                'filename' => $filename,
                'jumlah_data' => Transaksi::count(),
            ])
            ->log('Export Laporan Transaksi Excel');

        return Excel::download(new LaporanTransaksiExport($dateRange), $filename);
    }

    public function pdf(Request $request)
    {
        $dateRangeInput = $request->get('date_range');

        $user = Auth::user();
        $query = Transaksi::with(['detailTransaksi', 'pelanggan', 'typePelanggan', 'detailKasir'])
            ->filterByUserRole($user);

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

        $filename = 'laporan-transaksi.pdf';

        activity()
            ->useLog('Laporan Transaksi')
            ->performedOn(new Transaksi)
            ->causedBy(Auth::user())
            ->event('export')
            ->withProperties([
                'date_range' => $dateRange,
                'filename' => $filename,
                'jumlah_data' => $transaksis->count(),
            ])
            ->log('Export Laporan Transaksi PDF');

        $pdf = PDF::loadView('report.laporan-transaksi.pdf', compact('transaksis', 'dateRange'));
        return $pdf->download($filename);
    }
}
