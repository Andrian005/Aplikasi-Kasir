<?php

namespace App\Models;

use App\Models\Pelanggan;
use App\Models\TypePelanggan;
use App\Models\DetailTransaksi;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'transaksis';
    protected $primary_key = 'id';
    protected $fillable = [
        'invoice',
        'kasir_id',
        'pelanggan_id',
        'total_belanja',
        'diskon',
        'ppn',
        'total_akhir',
        'poin_member_didapat',
        'poin_member_digunakan',
        'pembayaran',
        'kembalian',
        'created_at',
        'updated_by',
        'created_by',
        'updated_by'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id')
            ->select(['id', 'transaksi_id', 'barang_id', 'jumlah_barang', 'harga_satuan', 'sub_total']);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)
            ->select(['id', 'nama_pelanggan', 'alamat', 'nomor_telepon', 'poin_member', 'type_pelanggan_id']);
    }

    public function typePelanggan()
    {
        return $this->belongsTo(TypePelanggan::class, 'type_pelanggan_id', 'id')
            ->select(['id', 'type']);
    }

    public function detailKasir()
    {
        return $this->belongsTo(User::class, 'kasir_id')
            ->select(['id', 'name']);
    }

    public function scopeFilterByUserRole($query, $user)
    {
        if ($user->role->role === 'Petugas Kasir') {
            return $query->where('kasir_id', $user->id);
        }
        return $query;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'invoice',
                'kasir_id',
                'pelanggan_id',
                'total_belanja',
                'diskon',
                'ppn',
                'total_akhir',
                'poin_member_didapat',
                'poin_member_digunakan',
                'pembayaran',
                'kembalian',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
