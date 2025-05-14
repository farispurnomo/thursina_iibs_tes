<?php

namespace Database\Seeders;

use App\Models\CoreRole;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CoreRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CoreRole::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            [
                'id'            => CoreRole::SUPERADMIN,
                'name'          => 'Superadmin',
                'created_at'    => Carbon::now()
            ]
        ];
        CoreRole::insert($roles);
    }
}
