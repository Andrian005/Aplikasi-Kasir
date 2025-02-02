<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\TypePelangganRepository;

class TypePelangganServices
{
    protected $typePelangganRepository;

    public function __construct(TypePelangganRepository $typePelangganRepository)
    {
        $this->typePelangganRepository = $typePelangganRepository;
    }

    public function index()
    {
        return $this->typePelangganRepository->getTypePelanggan();
    }

    public function find($id)
    {
        return $this->typePelangganRepository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $data = [
                'type' => $data['type'],
                'persen_keuntungan' => $data['persen_keuntungan'],
                'active' => 1,
                'created_by' => Auth::user()->name,
            ];

            $this->typePelangganRepository->store($data);

            DB::commit();
            return [
                'message' => 'Type Pelanggan Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Type Pelanggan Gagal di Tambah',
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
            $model = $this->typePelangganRepository->findById($id);

            $model->type = $data['type'];
            $model->persen_keuntungan = $data['persen_keuntungan'];
            $model->updated_at = Carbon::now();
            $model->updated_by = Auth::user()->name;

            $this->typePelangganRepository->update($id, $data);

            DB::commit();
            return [
                'message' => 'Type Pelanggan Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Type Pelanggan Gagal di Update',
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

            $this->typePelangganRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Type Pelanggan Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Type Pelanggan Gagal Dihapus',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
