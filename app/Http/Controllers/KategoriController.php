<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Services\KategoriServices;
use Exception;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    protected $kategoriServices;

    public function __construct(KategoriServices $kategoriServices)
    {
        $this->kategoriServices = $kategoriServices;
    }

    public function index(Request $request)
    {
        $title = 'Kategori Barang';
        if ($request->ajax()) {
            $model = $this->kategoriServices->index();
            return DataTables::of($model)->make(true);
        }

        return view('manajement-barang.kategori.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->kategoriServices->find($id);
        return view('manajement-barang.kategori.view', compact('model'));
    }

    public function create()
    {
        return view('manajement-barang.kategori.create');
    }

    public function store(KategoriRequest $request)
    {
        $data = $this->kategoriServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->kategoriServices->find($id);
        return view('manajement-barang.kategori.edit', compact('data'));
    }

    public function update(KategoriRequest $request, $id)
    {
        $data = $this->kategoriServices->Update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->kategoriServices->delete($id);
        return response()->json($data);
    }
}
