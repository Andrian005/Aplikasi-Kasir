<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use App\Repository\RoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleServices
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        return $this->roleRepository->getRole();
    }

    public function find($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $data = [
                'role' => $data['role'],
                'created_by' => Auth::user()->name,
            ];

            $this->roleRepository->store($data);

            DB::commit();
            return [
                'message' => 'Kategori Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Kategori Berhasil di Tambah',
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
            $model = $this->roleRepository->findById($id);

            $model->role = $data['role'];
            $model->updated_at = Carbon::now();
            $model->updated_by = Auth::user()->name;

            $this->roleRepository->update($id, $data);
            DB::commit();
            return [
                'message' => 'Role Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Kategori Berhasil di Tambah',
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

            $this->roleRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Role Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Role Gagal Dihapus',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
