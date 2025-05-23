<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primary_key = 'id';
    protected $fillable = ['role', 'created_at', 'updated_at', 'created_by', 'updated_by'];
}
