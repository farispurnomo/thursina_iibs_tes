<?php

namespace Database\Seeders;

use App\Models\CoreRole;
use App\Models\CoreUser;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CoreUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoreUser::truncate();

        $users = [
            [
                'id'            => '0e46f110-3d4f-11ed-9670-a1d5c62051e7',
                'email'         => 'admin@mail.com',
                'name'          => 'ADMINISTRATOR',
                'password'      => bcrypt('admin'),
                'image'         => null,
                'phone'         => null,
                'role_id'       => CoreRole::SUPERADMIN,
                'address'       => null,
                'created_at'    => Carbon::now()
            ],
        ];

        CoreUser::insert($users);
    }
}
