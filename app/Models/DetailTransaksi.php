<?php

namespace App\Models;

use App\Models\Barang;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaksi extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'detail_transaksis';
    protected $primary_key = 'id';
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'jumlah_barang',
        'harga_satuan',
        'sub_total',
        'created_at',
        'updated_by',
        'created_by',
        'updated_by'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'transaksi_id',
                'barang_id',
                'jumlah_barang',
                'harga_satuan',
                'sub_total',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
