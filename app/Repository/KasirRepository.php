<?php

namespace App\Repository;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Diskon;
use App\Models\Pelanggan;
use App\Models\Transaksi;

class KasirRepository
{
    protected $pelanggan;
    protected $diskon;
    protected $transaksi;
    protected $detailTransaksi;
    protected $barang;

    public function __construct(Pelanggan $pelanggan, Diskon $diskon, Transaksi $transaksi, DetailTransaksi $detailTransaksi, Barang $barang)
    {
        $this->pelanggan = $pelanggan;
        $this->diskon = $diskon;
        $this->transaksi = $transaksi;
        $this->detailTransaksi = $detailTransaksi;
        $this->barang = $barang;
    }

    public function getDiskon($type_pelanggan)
    {
        return $this->diskon::select(
            'id',
            'kode_diskon',
            'nama_diskon',
            'min_diskon',
            'max_diskon',
            'diskon',
            'type_pelanggan_id',
            'tgl_mulai',
            'tgl_berakhir'
        )
            ->where('type_pelanggan_id', $type_pelanggan)
            ->whereDate('tgl_mulai', '<=', now())
            ->where(function ($query) {
                $query->whereNull('tgl_berakhir')
                    ->orWhereDate('tgl_berakhir', '>', now());
            })
            ->get();
    }

    public function getBarang()
    {
        return $this->barang::select('id', 'nama_barang', 'tgl_kadaluarsa', 'harga_beli',  'harga_jual_1', 'harga_jual_2', 'harga_jual_3','stok_minimal', 'stok')
            ->where('tgl_kadaluarsa', '>', now())
            ->where('stok', '>', 0)
            ->get();
    }

    public function storeTransaksi($data)
    {
        return $this->transaksi::create($data);
    }

    public function storeDetailTransaksi($data)
    {
        return $this->detailTransaksi::insert($data);
    }

    public function updateBarang($id, $data)
    {
        return $this->barang->findOrFail($id)->update($data);
    }

    public function updatePoin($id, $data)
    {
        $this->pelanggan->findOrFail($id)->update($data);
    }

    public function invoice($transaksiId)
    {
        return $this->transaksi::with(['detailTransaksi', 'pelanggan', 'typePelanggan'])->findOrFail($transaksiId);
    }

}
