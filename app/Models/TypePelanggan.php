<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePelanggan extends Model
{
    use HasFactory;

    protected $table = 'type_pelanggans';
    protected $primary_key = 'id';
    protected $fillable = ['type', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public function hargaJual()
    {
        return $this->hasMany(HargaJual::class, 'type_pelanggan_id', 'id');
    }

    public function diskon()
    {
        return $this->hasMany(Diskon::class, 'type_pelanggan_id', 'id');
    }
}
