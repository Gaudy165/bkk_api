<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $majors = [
        ['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak'],
        ['code' => 'DKV', 'name' => 'Desain Komunikasi Visual'],
        ['code' => 'TKJ', 'name' => 'Teknik Komputer dan Jaringan'],
        ['code' => 'MKT', 'name' => 'Mekatronika'],
        ['code' => 'TPBO', 'name' => 'Teknik Body Otomotif'],
        ['code' => 'TL', 'name' => 'Teknik Pengelasan'],
        ['code' => 'TBKR', 'name' => 'Teknik Body Kendaraan Ringan'],
        ['code' => 'TPM', 'name' => 'Teknik Pemesinan'],
        ['code' => 'ATPH', 'name' => 'Agribisnis Tanaman Pangan dan Hortikultura'],
        ['code' => 'APHP', 'name' => 'Agribisnis Pengolahan Hasil Pertanian'],
    ];

    foreach ($majors as $major) {
        Major::updateOrCreate(
            ['code' => $major['code']], // cari berdasarkan code
            ['name' => $major['name']]  // update name nya
        );
    }
}
}
