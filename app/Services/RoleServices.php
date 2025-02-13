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
}
