<?php

namespace App\Repository;

use App\Models\Kategori;

class KategoriRepository
{
    protected $kategori;

    public function __construct(Kategori $kategori)
    {
        $this->kategori = $kategori;
    }
    public function getKategori()
    {
        return $this->kategori::select('*');
    }

    public function findById($id)
    {
        return $this->kategori::findOrFail($id);
    }

    public function store($data)
    {
        return $this->kategori::create($data);
    }

    public function update($id, $data)
    {
        return $this->kategori->findOrFail($id)->update($data);
    }

    public function delete($data)
    {
        return $this->kategori->findOrFail($data)->delete();
    }

}
