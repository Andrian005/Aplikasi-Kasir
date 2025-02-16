<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\BarangServices;
use App\Http\Requests\BarangRequest;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    protected $barangServices;

    public function __construct(BarangServices $barangServices)
    {
        $this->barangServices = $barangServices;
    }

    public function index(Request $request)
    {
        $title = 'Data Barang';
        if ($request->ajax()) {
            $model = $this->barangServices->index();
            return DataTables::of($model)
                ->addColumn('status', function ($row) {
                    return Carbon::now()->gt($row->tgl_kadaluarsa) ? '<div class="badge badge-danger">Kadaluarsa</div>' : '<div class="badge badge-success">Masih Berlaku</div>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('barang.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->barangServices->find($id);
        return view('barang.view', compact('model'));
    }

    public function create()
    {
        $title = 'Tambah Barang';
        $model = $this->barangServices->getKategori();
        return view('barang.create', compact('title', 'model'));
    }

    public function store(BarangRequest $request)
    {
        $data = $this->barangServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $title = 'Edit Barang';
        $data = $this->barangServices->find($id);
        $model = $this->barangServices->getKategori();
        return view('barang.edit', compact('title', 'data', 'model'));
    }

    public function update(BarangRequest $request, $id)
    {
        $data = $this->barangServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->barangServices->delete($id);
        return response()->json($data);
    }

}
