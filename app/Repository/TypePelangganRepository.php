<?php

namespace App\Repository;

use App\Models\TypePelanggan;

class TypePelangganRepository
{
    protected $typePelanggan;

    public function __construct(TypePelanggan $typePelanggan)
    {
        $this->typePelanggan = $typePelanggan;
    }

    public function getTypePelanggan()
    {
        return $this->typePelanggan::all();
    }

    public function findById($id)
    {
        return $this->typePelanggan::findOrFail($id);
    }

    public function store($data)
    {
        return $this->typePelanggan::create($data);
    }

    public function update($id, $data)
    {
        return $this->typePelanggan->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->typePelanggan->findOrFail($id)->delete();
    }
}
