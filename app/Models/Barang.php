<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'barangs';
    protected $primary_key = 'id';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'tgl_pembelian',
        'tgl_kadaluarsa',
        'harga_beli',
        'harga_jual_1',
        'harga_jual_2',
        'harga_jual_3',
        'stok_minimal',
        'stok',
        'kategori_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'kode_barang',
                'nama_barang',
                'tgl_pembelian',
                'tgl_kadaluarsa',
                'harga_beli',
                'harga_jual_1',
                'harga_jual_2',
                'harga_jual_3',
                'stok_minimal',
                'stok',
                'kategori_id',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
