<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\PelangganRepository;

class PelangganServices
{
    protected $pelangganRepository;

    public function __construct(PelangganRepository $pelangganRepository)
    {
        $this->pelangganRepository = $pelangganRepository;
    }

    public function index()
    {
        $data = $this->pelangganRepository->getPelanggan();
        return $data;
    }

    public function find($id)
    {
        $data = $this->pelangganRepository->findById($id);
        return $data;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data = [
                'nama_pelanggan' => $data['nama_pelanggan'],
                'alamat' => $data['alamat'],
                'nomor_telepon' => '62' . $data['nomor_telepon'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'type_pelanggan_id' => $data['type_pelanggan_id'],
                'poin_member' => 0,
                'created_by' => Auth::user()->name,
            ];

            $this->pelangganRepository->store($data);

            DB::commit();
            return [
                'message' => 'Pelanggan Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Pelanggan Gagal di Tambah',
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
                'nama_pelanggan' => $data['nama_pelanggan'],
                'alamat' => $data['alamat'],
                'nomor_telepon' => $data['nomor_telepon'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'type_pelanggan_id' => $data['type_pelanggan_id'],
                'poin_member' => $data['poin_member'],
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::user()->name,
            ];

            $this->pelangganRepository->update($id, $data);

            DB::commit();
            return [
                'message' => 'Pelanggan Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Pelanggan Gagal di Update',
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

            $this->pelangganRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Pelanggan Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Pelanggan Gagal Delete',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function getTypePelanggan()
    {
        return $this->pelangganRepository->getTypePelanggan();
    }
}
