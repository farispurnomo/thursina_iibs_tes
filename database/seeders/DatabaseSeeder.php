<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(AppSettingsTableSeeder::class);
        $this->call(CoreRolesTableSeeder::class);
        $this->call(CoreUsersTableSeeder::class);
        $this->call(CoreMenusTableSeeder::class);
        $this->call(CoreMenuAbilitiesTableSeeder::class);
        $this->call(CorePrivilegesTableSeeder::class);

        $this->call(MstKategoriPaketTableSeeder::class);
        $this->call(MstAsramaTableSeeder::class);
        $this->call(MstSantriTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
