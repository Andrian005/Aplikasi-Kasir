<?php

namespace App\Repository;

use App\Models\Diskon;
use Illuminate\Support\Facades\DB;

class DiskonRepository
{
    protected $diskon;

    public function __construct(Diskon $diskon)
    {
        $this->diskon = $diskon;
    }

    public function getDiskon()
    {
        return $this->diskon::with('type')->get();
    }

    public function findById($id)
    {
        return $this->diskon::with('type')
        ->select(
            '*',
            DB::raw("CASE
                WHEN tgl_berakhir >= NOW() THEN 'Masih Berlaku'
                ELSE 'Kadaluarsa'
            END as status"))
        ->findOrFail($id);
    }

    public function store($data)
    {
        return $this->diskon::create($data);
    }

    public function update($id, $data)
    {
        return $this->diskon->whereRaw($id)->update($data);
    }

    public function delete($id)
    {
        return $this->diskon->findOrFail($id)->delete();
    }
}
