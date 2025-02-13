<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diskon extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'diskons';
    protected $primary_key = 'id';
    protected $fillable = [
        'kode_diskon',
        'nama_diskon',
        'min_diskon',
        'max_diskon',
        'diskon',
        'type_pelanggan_id',
        'tgl_mulai',
        'tgl_berakhir',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function type()
    {
        return $this->belongsTo(TypePelanggan::class, 'type_pelanggan_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'kode_diskon',
                'nama_diskon',
                'min_diskon',
                'max_diskon',
                'diskon',
                'type_pelanggan_id',
                'tgl_mulai',
                'tgl_berakhir',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
