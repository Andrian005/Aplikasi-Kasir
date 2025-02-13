<?php

namespace Database\Seeders;

use App\Models\TypePelanggan;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypePelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypePelanggan::insert([
            [
                'type' => 'Type 1',
                'created_at' => Carbon::now(),
                'created_by' => 'Sistem'
            ],
            [
                'type' => 'Type 2',
                'created_at' => Carbon::now(),
                'created_by' => 'Sistem'
            ],
            [
                'type' => 'Type 3',
                'created_at' => Carbon::now(),
                'created_by' => 'Sistem'
            ],
        ]);
    }
}
