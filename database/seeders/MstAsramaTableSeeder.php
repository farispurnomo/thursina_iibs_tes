<?php

namespace Database\Seeders;

use App\Models\MstAsrama;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class MstAsramaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MstAsrama::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $records = [
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Asrama 1',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Asrama 2',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => Uuid::generate()->string,
                'nama'          => 'Asrama 3',
                'created_at'    => Carbon::now()
            ]
        ];
        MstAsrama::insert($records);
    }
}
