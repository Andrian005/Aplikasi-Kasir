<?php

namespace App\Repository;

use App\Models\Pelanggan;
use App\Models\TypePelanggan;

class PelangganRepository
{
    protected $pelanggan;
    protected $typePelanggan;

    public function __construct(Pelanggan $pelanggan, TypePelanggan $typePelanggan)
    {
        $this->pelanggan = $pelanggan;
        $this->typePelanggan = $typePelanggan;
    }
    public function getPelanggan()
    {
        return $this->pelanggan->with('typePelanggan:id,type')->select('*')->get();
    }

    public function findById($id)
    {
        return $this->pelanggan::findOrFail($id);
    }

    public function store($data)
    {
        return $this->pelanggan::create($data);
    }

    public function update($id, $data)
    {
        return $this->pelanggan->findOrFail($id)->update($data);
    }

    public function delete($data)
    {
        return $this->pelanggan->findOrFail($data)->delete();
    }

    public function getTypePelanggan()
    {
        return $this->typePelanggan::all();
    }
}
