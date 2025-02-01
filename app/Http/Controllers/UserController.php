<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\RoleServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userServices;
    protected $roleServices;

    public function __construct(UserServices $userServices, RoleServices $roleServices)
    {
        $this->userServices = $userServices;
        $this->roleServices = $roleServices;
    }

    public function index(Request $request)
    {
        $title = 'User';
        if ($request->ajax()) {
            $model = $this->userServices->index();
            return DataTables::of($model)->make(true);
        }
        return view('user-management.user.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->userServices->find($id);
        return view('user-management.user.view', compact('model'));
    }

    public function create()
    {
        $model = $this->roleServices->index();
        return view('user-management.user.create', compact('model'));
    }

    public function store(UserRequest $request )
    {
        $data = $this->userServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->userServices->find($id);
        $model = $this->roleServices->index();
        return view('user-management.user.edit', compact('data', 'model'));
    }

    public function update(UserRequest $request, $id)
    {
        $data = $this->userServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->userServices->delete($id);
        return response()->json($data);
    }
}
