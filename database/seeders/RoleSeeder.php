<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'role' => 'Administrator',
                'created_at' => Carbon::now(),
                'created_by' => 'Sistem',
            ],
            [
                'role' => 'Petugas Kasir',
                'created_at' => Carbon::now(),
                'created_by' => 'Sistem',
            ]
        ]);
    }
}
