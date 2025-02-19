<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repository\BarangRepository;
use Illuminate\Support\Facades\Auth;

class BarangServices
{
    protected $barangRepository;

    public function __construct(BarangRepository $barangRepository)
    {
        $this->barangRepository = $barangRepository;
    }

    public function index()
    {
        return $this->barangRepository->getBarang();
    }

    public function find($id)
    {
        return $this->barangRepository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $hpp = str_replace(',', '', $data['harga_beli']);
            $hj1 = str_replace('.', '', $data['harga_jual_1']);
            $hj2 = str_replace('.', '', $data['harga_jual_2']);
            $hj3 = str_replace('.', '', $data['harga_jual_3']);
            $data = [
                'kode_barang' => $data['kode_barang'],
                'nama_barang' => $data['nama_barang'],
                'tgl_pembelian' => $data['tgl_pembelian'],
                'tgl_kadaluarsa' => $data['tgl_kadaluarsa'],
                'harga_beli' => $hpp,
                'harga_jual_1' => $hj1,
                'harga_jual_2' => $hj2,
                'harga_jual_3' => $hj3,
                'stok' => $data['stok'],
                'stok_minimal' => $data['stok_minimal'],
                'kategori_id' => $data['kategori_id'],
                'created_by' => Auth::user()->name,
            ];

            $this->barangRepository->storeBarang($data);

            DB::commit();
            return [
                'message' => 'Barang Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Barang Gagal di Tambah',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {

            $hpp = str_replace(',', '', $data['harga_beli']);
            $hj1 = str_replace(['.', ','], '', $data['harga_jual_1']);
            $hj2 = str_replace(['.', ','], '', $data['harga_jual_2']);
            $hj3 = str_replace(['.', ','], '', $data['harga_jual_3']);
            $data = [
                'kode_barang' => $data['kode_barang'],
                'nama_barang' => $data['nama_barang'],
                'tgl_pembelian' => $data['tgl_pembelian'],
                'tgl_kadaluarsa' => $data['tgl_kadaluarsa'],
                'harga_beli' => $hpp,
                'harga_jual_1' => $hj1,
                'harga_jual_2' => $hj2,
                'harga_jual_3' => $hj3,
                'stok' => $data['stok'],
                'stok_minimal' => $data['stok_minimal'],
                'kategori_id' => $data['kategori_id'],
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::user()->name,
            ];

            $this->barangRepository->update($id, $data);

            DB::commit();
            return [
                'message' => 'Barang Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Barang Gagal di Update',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {

            $this->barangRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Barang Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Barang Gagal di Delete',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function getKategori()
    {
        return $this->barangRepository->getKategori();
    }

    public function storeStok($data, $id)
    {
        DB::beginTransaction();
        try {

            $data = [
                'barang_id' => $id,
                'jumlah_stok' => $data['jumlah_stok'],
                'tgl_pembelian' => $data['tgl_pembelian'],
                'tgl_kadaluarsa' => $data['tgl_kadaluarsa'],
                'created_by' => Auth::user()->name,
            ];

            $this->barangRepository->storeStok($data);

            DB::commit();
            return [
                'message' => 'Stok Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Stok Gagal di Tambah',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
