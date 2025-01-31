<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primary_key = 'id';
    protected $fillable = ['kode_kategori', 'nama_kategori', 'active', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
