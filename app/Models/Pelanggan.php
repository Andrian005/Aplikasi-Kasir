<?php

namespace App\Models;

use App\Models\TypePelanggan;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nama_pelanggan',
                'alamat',
                'nomor_telepon',
                'jenis_kelamin',
                'type_pelanggan_id',
                'poin_member',
            ])
            ->useLogName(Auth::user()->name)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
