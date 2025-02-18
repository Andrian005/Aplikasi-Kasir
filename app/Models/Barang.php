<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'barang_id')
            ->selectRaw('barang_id, SUM(jumlah_barang) as total_jumlah_barang')
            ->groupBy('barang_id');
    }

    public function getStokAwalAttribute()
    {
        return $this->stok + ($this->detailTransaksi->sum('total_jumlah_barang') ?? 0);
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

    public function getHargaByTipe($tipe)
    {
        return match ($tipe) {
            'Type 1' => $this->harga_jual_1,
            'Type 2' => $this->harga_jual_2,
            'Type 3' => $this->harga_jual_3,
            default => $this->harga_jual_3,
        };
    }
}
