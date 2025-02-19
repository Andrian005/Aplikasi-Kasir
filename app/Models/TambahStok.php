<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class TambahStok extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'tambah_stoks';
    protected $primary_key = 'id';
    protected $fillable = ['barang_id', 'jumlah_stok', 'tgl_pembelian', 'tgl_kadaluarsa', 'created_by', 'updated_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'barang_id',
                'jumlah_stok',
                'tgl_pembelian',
                'tgl_kadaluarsa',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
