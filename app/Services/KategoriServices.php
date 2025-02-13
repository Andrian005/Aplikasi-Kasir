<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\KategoriRepository;

class KategoriServices
{
    protected $kategoriRepository;

    public function __construct(KategoriRepository $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    public function index()
    {
        $data = $this->kategoriRepository->getKategori();
        return $data;
    }

    public function find($id)
    {
        $data = $this->kategoriRepository->findById($id);
        return $data;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data = [
                'kode_kategori' => $data['kode_kategori'],
                'nama_kategori' => $data['nama_kategori'],
                'created_by' => Auth::user()->name,
            ];

            $this->kategoriRepository->store($data);

            DB::commit();
            return [
                'message' => 'Kategori Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Kategori Gagal di Tambah',
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

            $data = [
                'kode_kategori' => $data['kode_kategori'],
                'nama_kategori' => $data['nama_kategori'],
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::user()->name,
            ];

            $this->kategoriRepository->update($id, $data);

            DB::commit();
            return [
                'message' => 'Kategori Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Kategori Gagal di Update',
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

            $this->kategoriRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Kategori Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Kategori Gagal Dihapus',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
