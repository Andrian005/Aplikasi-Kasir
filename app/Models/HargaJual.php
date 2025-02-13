<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaJual extends Model
{
    use HasFactory;

    protected $table = 'harga_juals';
    protected $primary_key = 'id';
    protected $fillable = ['barang_id', 'harga_jual', 'type_pelanggan_id', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public function typePelanggan()
    {
        return $this->belongsTo(TypePelanggan::class, 'id', 'type_pelanggan_id');
    }
}
