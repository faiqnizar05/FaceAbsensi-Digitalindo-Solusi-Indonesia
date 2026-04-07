<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('data_user')->insert([
            [
                'id'         => 1,
                'username'   => 'Alya safira',
                'kelas'      => 'XII PPLG 1',
                'image'      => 'uploads/seeds/1765312674_Ilan al iman.jpg',
                'created_at' => '2025-11-19 07:36:14',
                'updated_at' => '2025-11-19 07:36:14',
            ],
            [
                'id'         => 2,
                'username'   => 'Ilan Al Iman',
                'kelas'      => 'XII PPLG 1',
                'image'      => 'uploads/seeds/1765312674_Ilan al iman.jpg',
                'created_at' => '2025-11-19 07:37:54',
                'updated_at' => '2025-11-19 07:37:54',
            ],
            [
                'id'         => 3,
                'username'   => 'Bayo adi purnomo',
                'kelas'      => 'XII PPLG 2',
                'image'      => 'uploads/seeds/1765312729_Bayu adi purnomo.jpg',
                'created_at' => '2025-11-19 07:38:49',
                'updated_at' => '2025-11-19 07:38:49',
            ],
            [
                'id'         => 4,
                'username'   => 'Sulton al fariz',
                'kelas'      => 'XII PPLG 1',
                'image'      => 'uploads/seeds/1765312780_Sulton al fariz.jpg',
                'created_at' => '2025-11-19 07:39:40',
                'updated_at' => '2025-11-19 07:39:40',
            ],
        ]);
    }
}
