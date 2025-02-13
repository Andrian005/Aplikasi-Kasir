<?php

namespace App\Repository;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\HargaJual;
use Illuminate\Support\Facades\DB;

class BarangRepository
{
    protected $barang;
    protected $hargaJual;
    protected $kategori;

    public function __construct(Barang $barang, HargaJual $hargaJual, Kategori $kategori)
    {
        $this->barang = $barang;
        $this->hargaJual = $hargaJual;
        $this->kategori = $kategori;
    }

    public function getBarang()
    {
        return $this->barang::with('kategori')->get();
    }

    public function findById($id)
    {
        return $this->barang::with('kategori')
            ->select(
                '*',
                DB::raw("CASE
                    WHEN tgl_kadaluarsa >= NOW() THEN 'Masih Berlaku'
                    ELSE 'Kadaluarsa'
                    END as status"),
                DB::raw("CASE
                    WHEN stok = 0 THEN 'Stok Habis'
                    WHEN stok < stok_minimal THEN 'Stok Menipis'
                    END as status_stok")
            )->findOrFail($id);
    }

    public function storeBarang($data)
    {
        return $this->barang::create($data);
    }

    public function storeHargaJual($data)
    {
        return $this->hargaJual::create($data);
    }

    public function update($id, $data)
    {
        return $this->barang->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->barang->findOrFail($id)->delete();
    }

    public function getKategori()
    {
        return $this->kategori::with('barang')->get();
    }
}
