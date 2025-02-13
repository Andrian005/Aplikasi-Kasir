<?php

namespace App\Repository;

use App\Models\Role;
use App\Models\User;

class UserRepository
{
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function getUser()
    {
        return $this->user->with('role')->select('id', 'name', 'email', 'role_id')->get();
    }

    public function findById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function store($data)
    {
        return $this->user::create($data);
    }

    public function update($id, $data)
    {
        return $this->user->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->user->findOrFail($id)->delete();
    }

}
