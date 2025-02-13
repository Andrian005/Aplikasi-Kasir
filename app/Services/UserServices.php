<?php

namespace App\Services;

use App\Repository\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->getUser();
    }

    public function find($id)
    {
        return $this->userRepository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role'],
            ];

            $this->userRepository->store($data);

            DB::commit();
            return [
                'message' => 'User Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'User Gagal di Tambah',
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
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role']
            ];

            if (empty($data['password'])) {
                unset($data['password']);
                unset($data['confirmed_password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            $this->userRepository->update($id, $data);
            DB::commit();
            return [
                'message' => 'User Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'User Gagal di Update',
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

            $this->userRepository->delete($id);

            DB::commit();
            return [
                'message' => 'User Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'User Gagal Delete',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
