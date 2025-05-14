<?php

namespace Database\Seeders;

use App\Models\MstKategoriPaket;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class MstKategoriPaketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MstKategoriPaket::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $records = [
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Makanan Basah',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Makanan Kering (snack)',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Non Makanan',
                'created_at'    => Carbon::now()
            ]
        ];
        MstKategoriPaket::insert($records);
    }
}
