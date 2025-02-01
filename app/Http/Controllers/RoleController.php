<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    protected $roleServices;

    public function __construct(RoleServices $roleServices)
    {
        $this->roleServices = $roleServices;
    }

    public function index(Request $request)
    {
        $title = 'Role';
        if ($request->ajax()) {
            $model = $this->roleServices->index();
            return DataTables::of($model)->make(true);
        }

        return view('user-management.role.index', compact('title'));
    }

    Public function view($id)
    {
        $model = $this->roleServices->find($id);
        return view('user-management.role.view', compact('model'));
    }

    public function create()
    {
        return view('user-management.role.create');
    }

    public function store(RoleRequest $request)
    {
        $data = $this->roleServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->roleServices->find($id);
        return view('user-management.role.edit', compact('data'));
    }

    public function update(RoleRequest $request, $id)
    {
        $data = $this->roleServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->roleServices->delete($id);
        return response()->json($data);
    }
}
