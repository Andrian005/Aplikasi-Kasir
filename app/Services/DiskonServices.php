<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repository\DiskonRepository;
use Illuminate\Support\Facades\Auth;

class DiskonServices
{
    protected $diskonRepository;

    public function __construct(DiskonRepository $diskonRepository)
    {
        $this->diskonRepository = $diskonRepository;
    }

    public function index()
    {
        return $this->diskonRepository->getDiskon();
    }

    public function find($id)
    {
        return $this->diskonRepository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $min = str_replace(',', '', $data['min_diskon']);
            $max = str_replace(',', '', $data['max_diskon']);
            $data = [
                'kode_diskon' => $data['kode_diskon'],
                'nama_diskon' => $data['nama_diskon'],
                'min_diskon' => $min,
                'max_diskon' => $max,
                'diskon' => $data['diskon'],
                'type_pelanggan_id' => $data['type_pelanggan_id'],
                'tgl_mulai' => $data['tgl_mulai'],
                'tgl_berakhir' => $data['tgl_berakhir'],
                'created_by' => Auth::user()->name,
            ];

            $this->diskonRepository->store($data);

            DB::commit();
            return [
                'message' => 'Diskon Berhasil di Tambah',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Diskon Gagal di Tambah',
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

            $min = str_replace(',', '', $data['min_diskon']);
            $max = str_replace(',', '', $data['max_diskon']);

            $data = [
                'kode_diskon' => $data['kode_diskon'],
                'nama_diskon' => $data['nama_diskon'],
                'min_diskon' => $min,
                'max_diskon' => $max,
                'diskon' => $data['diskon'],
                'type_pelanggan_id' => $data['type_pelanggan_id'],
                'tgl_mulai' => $data['tgl_mulai'],
                'tgl_berakhir' => $data['tgl_berakhir'],
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::user()->name,
            ];

            $this->diskonRepository->update($id, $data);

            DB::commit();
            return [
                'message' => 'Diskon Berhasil di Update',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Diskon Gagal di Update',
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

            $this->diskonRepository->delete($id);

            DB::commit();
            return [
                'message' => 'Diskon Berhasil di Delete',
                'success' => true,
                'status' => 200
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Diskon Gagal Dihapus',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }
}
