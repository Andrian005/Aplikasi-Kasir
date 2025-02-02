<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePelanggan extends Model
{
    use HasFactory;

    protected $table = 'type_pelanggans';
    protected $primary_key = 'id';
    protected $fillable = ['type', 'persen_keuntungan', 'active', 'created_at', 'updated_at', 'created_by', 'updated_by'];
}
