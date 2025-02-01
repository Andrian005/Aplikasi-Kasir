<?php

namespace App\Repository;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role::all();
    }

    public function findById($id)
    {
        return $this->role::findOrFail($id);
    }

    public function store($data)
    {
        return $this->role::create($data);
    }

    public function update($id, $data)
    {
        return $this->role->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->role->findOrFail($id)->delete();
    }
}
