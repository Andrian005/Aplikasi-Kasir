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

    public function getTypePelangganDiskon()
    {
        return $this->typePelanggan::with('diskon')->get();
    }

    public function findById($id)
    {
        return $this->typePelanggan::findOrFail($id);
    }
}
