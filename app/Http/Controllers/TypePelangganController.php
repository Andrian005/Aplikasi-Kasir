<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypePelangganRequest;
use App\Services\TypePelangganServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypePelangganController extends Controller
{
    protected $typePelangganServices;

    public function __construct(TypePelangganServices $typePelangganServices)
    {
        $this->typePelangganServices = $typePelangganServices;
    }

    public function index(Request $request)
    {
        $title = 'Type Pelanggan';
        if ($request->ajax()) {
            $model = $this->typePelangganServices->index();
            return DataTables::of($model)->make(true);
        };
        return view('management-pelanggan.type-pelanggan.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->typePelangganServices->find($id);
        return view('management-pelanggan.type-pelanggan.view', compact('model'));
    }

    public function create()
    {
        return view('management-pelanggan.type-pelanggan.create');
    }

    public function store(TypePelangganRequest $request)
    {
        $data = $this->typePelangganServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->typePelangganServices->find($id);
        return view('management-pelanggan.type-pelanggan.edit', compact('data'));
    }

    public function update(TypePelangganRequest $request, $id)
    {
        $data = $this->typePelangganServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->typePelangganServices->delete($id);
        return response()->json($data);
    }
}
