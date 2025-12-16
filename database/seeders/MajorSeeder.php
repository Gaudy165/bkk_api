<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('majors')->insert([
            ['name' => 'Rekayasa Perangkat Lunak', 'code' => 'RPL'],
            ['name' => 'Desain Komunikasi Visual', 'code' => 'DKV'],
            ['name' => 'Teknik Komputer dan Jaringan', 'code' => 'TKJ'],
            ['name' => 'Mekatronika', 'code' => 'MKT'],
            ['name' => 'Teknik Body Otomotif', 'code' => 'TPBO'],
            ['name' => 'Teknik Pengelasan', 'code' => 'TL'],
            ['name' => 'Teknik Body Kendaraan Ringan', 'code' => 'TBKR'],
            ['name' => 'Teknik Pemesinan', 'code' => 'TPM'],
            ['name' => 'Agribisnis Tanaman Pangan dan Hortikultura', 'code' => 'ATPH'],
            ['name' => 'Agribisnis Pengolahan Hasil Pertanian', 'code' => 'APHP'],
        ]);
    }
}
