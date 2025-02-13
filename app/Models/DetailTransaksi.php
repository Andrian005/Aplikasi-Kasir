<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

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
}
