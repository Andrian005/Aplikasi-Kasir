<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'kategoris';
    protected $primary_key = 'id';
    protected $fillable = ['kode_kategori', 'nama_kategori', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'kode_kategori',
                'nama_kategori',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
