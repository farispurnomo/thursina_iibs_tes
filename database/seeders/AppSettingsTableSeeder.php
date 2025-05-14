<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AppSetting::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $settings = [
            [
                'name'          => AppSetting::PROVINSI_ID,
                'value'         => 'cf5573a0-3169-11ef-9fbe-61199b1df55c',
                'created_at'    => Carbon::now()
            ],
        ];

        AppSetting::insert($settings);
    }
}
