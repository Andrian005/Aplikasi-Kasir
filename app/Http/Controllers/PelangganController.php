<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelangganRequest;
use Illuminate\Http\Request;
use App\Services\PelangganServices;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    protected $pelangganServices;

    public function __construct(PelangganServices $pelangganServices)
    {
        $this->pelangganServices = $pelangganServices;
    }

    public function index(Request $request)
    {
        $title = 'Pelanggan';
        if ($request->ajax()) {
            $model = $this->pelangganServices->index();
            return DataTables::of($model)->make(true);
        }

        return view('pelanggan.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->pelangganServices->find($id);
        return view('pelanggan.view', compact('model'));
    }

    public function create()
    {
        $model = $this->pelangganServices->getTypePelanggan();
        return view('pelanggan.create', compact('model'));
    }

    public function store(PelangganRequest $request)
    {
        $data = $this->pelangganServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->pelangganServices->find($id);
        $model = $this->pelangganServices->getTypePelanggan();
        return view('pelanggan.edit', compact('data', 'model'));
    }

    public function update(PelangganRequest $request, $id)
    {
        $data = $this->pelangganServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->pelangganServices->delete($id);
        return response()->json($data);
    }
}
