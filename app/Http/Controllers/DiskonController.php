<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\DiskonServices;
use App\Http\Requests\DiskonRequest;
use App\Services\TypePelangganServices;
use Yajra\DataTables\Facades\DataTables;

class DiskonController extends Controller
{
    protected $diskonServices;
    protected $typePelangganServices;

    public function __construct(DiskonServices $diskonServices, TypePelangganServices $typePelangganServices)
    {
        $this->diskonServices = $diskonServices;
        $this->typePelangganServices = $typePelangganServices;
    }

    public function index(Request $request)
    {
        $title = 'Data Diskon';
        if ($request->ajax()) {
            $model = $this->diskonServices->index();
            return DataTables::of($model)
            ->addColumn('status', function ($row) {
                return Carbon::now()->gt($row->tgl_berakhir) ? '<div class="badge badge-danger">Kadaluarsa</div>' : '<div class="badge badge-success">Masih Berlaku</div>';
            })
            ->rawColumns(['status'])
            ->make(true);
        }

        return view('list-data.diskon.index', compact('title'));
    }

    public function view($id)
    {
        $model = $this->diskonServices->find($id);
        return view('list-data.diskon.view', compact('model'));
    }

    public function create()
    {
        $title = 'Tambah Diskon';
        $type = $this->typePelangganServices->getTypePelangganDiskon();
        return view('list-data.diskon.create', compact('title', 'type'));
    }

    public function store(DiskonRequest $request)
    {
        $data = $this->diskonServices->store($request->validated());
        return response()->json($data);
    }

    public function edit($id)
    {
        $title = 'Edit Diskon';
        $data = $this->diskonServices->find($id);
        $type = $this->typePelangganServices->getTypePelangganDiskon();
        return view('list-data.diskon.edit', compact('title', 'data', 'type'));
    }

    public function update(DiskonRequest $request, $id)
    {
        $data = $this->diskonServices->update($request->validated(), $id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = $this->diskonServices->delete($id);
        return response()->json($data);
    }
}
