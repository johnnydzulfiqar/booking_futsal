<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lapangan;

class CreateLapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lapangan = [
            [
                'nama' => 'Lapangan Futsal',
                'harga' => '125000',
                'status' => 'Aktif',

            ],

        ];

        foreach ($lapangan as $key => $data) {
            Lapangan::create($data);
        }
    }
}
