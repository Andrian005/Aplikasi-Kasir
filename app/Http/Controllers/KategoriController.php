<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Services\KategoriServices;
use Illuminate\Http\Request;
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
        $title = 'Data Kategori';
        if ($request->ajax()) {
            $model = $this->kategoriServices->index();
            return DataTables::of($model)->make(true);
        }

        return view('list-data.kategori.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->kategoriServices->find($id);
        return view('list-data.kategori.view', compact('model'));
    }

    public function create()
    {
        return view('list-data.kategori.create');
    }

    public function store(KategoriRequest $request)
    {
        $data = $this->kategoriServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->kategoriServices->find($id);
        return view('list-data.kategori.edit', compact('data'));
    }

    public function update(KategoriRequest $request, $id)
    {
        $data = $this->kategoriServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->kategoriServices->delete($id);
        return response()->json($data);
    }
}
