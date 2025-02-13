<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';
    protected $primary_key = 'id';
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'nomor_telepon',
        'jenis_kelamin',
        'type_pelanggan_id',
        'poin_member',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function typePelanggan()
    {
        return $this->belongsTo(TypePelanggan::class, 'type_pelanggan_id', 'id');
    }
}
