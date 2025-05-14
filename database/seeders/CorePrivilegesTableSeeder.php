<?php

namespace Database\Seeders;

use App\Models\CorePrivilege;
use App\Models\CoreRole;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CorePrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CorePrivilege::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $privileges = $this->superadminPrivilege();

        CorePrivilege::insert($privileges);
    }

    private function superadminPrivilege()
    {
        return [
            // Dashboard
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '9771fbc0-33d8-11ed-ba52-bd4edf9d4c3f', // dahboard:data
                'created_at'    => Carbon::now()
            ],
            // Laporan -> Paket
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '51311660-36c6-11ef-bd47-7f4971695337', // lap_paket:delete
                'created_at'    => Carbon::now()
            ],
            // Setting -> Paket
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'aa869690-3158-11ef-b619-07c73d847949', // t_paket:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'b0e8c7b0-3158-11ef-911d-bf8f22936843', // t_paket:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'b6d3efe0-3158-11ef-9733-91b0237e8ab9', // t_paket:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'bcacbb80-3158-11ef-a628-730cac43d5ee', // t_paket:delete
                'created_at'    => Carbon::now()
            ],
            // Setting -> Santri
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '632c53f0-3158-11ef-8dca-899e978d9a0a', // mst_santri:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '8d592ac0-3158-11ef-b76f-71a8428885eb', // mst_santri:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '93fb1220-3158-11ef-87e5-914f9a32a81d', // mst_santri:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '992885b0-3158-11ef-82f3-3709d3854c3d', // mst_santri:delete
                'created_at'    => Carbon::now()
            ],
            // Setting -> Kategori Paket
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'c43c6250-3158-11ef-82ca-7f207ef271c1', // mst_kategori_paket:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'd2e177a0-3158-11ef-9fd6-95e4d0183a0a', // mst_kategori_paket:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'ce850d70-3158-11ef-805c-571ec4b0dba9', // mst_kategori_paket:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'd7573640-3158-11ef-a8b0-d310acca71a8', // mst_kategori_paket:delete
                'created_at'    => Carbon::now()
            ],
            // Setting -> Asrama
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'e59d75c0-3158-11ef-981c-bdab2b06d7ab', // mst_asrama:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'e9e2e150-3158-11ef-9b24-c5cf8c30b563', // mst_asrama:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'ef5eb9f0-3158-11ef-8226-11e456c60cee', // mst_asrama:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'f2ad7350-3158-11ef-bd51-dfed8006565b', // mst_asrama:delete
                'created_at'    => Carbon::now()
            ],
            // User
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '9c45a610-3e35-11ed-b616-bb2a0c5878de', // user:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'a06404c0-3e35-11ed-8b8c-f36c367192ad', // user:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'a3e6d460-3e35-11ed-a3d2-058c4fc89cd3', // user:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => 'a9348770-3e35-11ed-b86c-07b168af0e90', // user:delete
                'created_at'    => Carbon::now()
            ],
            // Role
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '09e3a860-5f0a-11ed-b7d2-696df24549b4', // role:read
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '0da44230-5f0a-11ed-adf6-ad15bedb8f47', // role:create
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '10b72620-5f0a-11ed-8832-af7c26253484', // role:update
                'created_at'    => Carbon::now()
            ],
            [
                'role_id'       => CoreRole::SUPERADMIN,
                'ability_id'    => '13bd20a0-5f0a-11ed-b64c-b1748a8c2a28', // role:delete
                'created_at'    => Carbon::now()
            ],
        ];
    }
}
