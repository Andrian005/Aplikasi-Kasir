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

    public function getTypePelangganDiskon()
    {
        return $this->typePelangganRepository->getTypePelangganDiskon();
    }

    public function find($id)
    {
        return $this->typePelangganRepository->findById($id);
    }
}
