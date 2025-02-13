<?php

namespace App\Http\Controllers;

use PDF;
use App\Services\KasirServices;
use App\Services\BarangServices;
use App\Services\DiskonServices;
use App\Services\PelangganServices;
use App\Http\Requests\TransaksiRequest;

class KasirController extends Controller
{
    protected $kasirServices;
    protected $pelangganServices;
    protected $diskonServices;
    protected $barangServices;

    public function __construct(KasirServices $kasirServices, PelangganServices $pelangganServices, DiskonServices $diskonServices, BarangServices $barangServices)
    {
        $this->kasirServices = $kasirServices;
        $this->pelangganServices = $pelangganServices;
        $this->diskonServices = $diskonServices;
        $this->barangServices = $barangServices;
    }

    public function index()
    {
        $title = 'Kasir';
        $dataPelanggan = $this->pelangganServices->index();
        $dataBarang = $this->barangServices->index();
        return view('kasir.index', compact('title', 'dataPelanggan', 'dataBarang'));
    }

    public function getPelanggan()
    {
        $dataPelanggan = $this->pelangganServices->index();
        return response()->json($dataPelanggan);
    }

    public function getBarang()
    {
        $dataBarang = $this->kasirServices->getBarang();
        return response()->json($dataBarang);
    }

    public function getDiskon($type_pelanggan_id)
    {
        $dataDiskon = $this->kasirServices->getDiskon($type_pelanggan_id);
        return response()->json($dataDiskon);
    }

    public function transaksi(TransaksiRequest $request)
    {
        $data = $this->kasirServices->store($request->validated());
        return response()->json($data);
    }

    public function invoice($transaksiId)
    {
        $transaksi = $this->kasirServices->invoice($transaksiId);
        return view('kasir.invoice', compact('transaksi'));
    }

    public function downloadInvoice($transaksiId)
    {
        $transaksi = $this->kasirServices->invoice($transaksiId);
        $pdf = PDF::loadView('kasir.invoice_pdf', compact('transaksi'));
        return $pdf->download('invoice_'.$transaksi->invoice.'.pdf');
    }

    public function printInvoice($transaksiId)
    {
        $transaksi = $this->kasirServices->invoice($transaksiId);
        $pdf = PDF::loadView('kasir.invoice_pdf', compact('transaksi'));
        return $pdf->stream('invoice_'.$transaksi->invoice.'.pdf');
    }
}
