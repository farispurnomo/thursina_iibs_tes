<?php

namespace Database\Seeders;

use App\Models\MstSantri;
use Illuminate\Database\Seeder;

class MstSantriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MstSantri::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        MstSantri::factory(50)
            ->create();
    }
}
