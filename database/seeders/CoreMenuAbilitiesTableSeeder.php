<?php

namespace Database\Seeders;

use App\Models\CoreMenuAbility;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreMenuAbilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CoreMenuAbility::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $abilities = [
            // Dashboard
            [
                'id'            => '9771fbc0-33d8-11ed-ba52-bd4edf9d4c3f',
                'menu_id'       => '1b0d37e0-33d8-11ed-bceb-57a813f27781',
                'name'          => 'dashboard:read',
                'description'   => 'dashboard:read',
                'created_at'    => Carbon::now()
            ],
            // Laporan -> Paket
            [
                'id'            => '51311660-36c6-11ef-bd47-7f4971695337',
                'menu_id'       => 'f51eaec0-36c5-11ef-8838-e5f828db163c',
                'name'          => 'lap_paket:read',
                'description'   => 'lap_paket:read',
                'created_at'    => Carbon::now()
            ],
            // Setting -> Paket
            [
                'id'            => 'aa869690-3158-11ef-b619-07c73d847949',
                'menu_id'       => '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97',
                'name'          => 't_paket:read',
                'description'   => 't_paket:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'b0e8c7b0-3158-11ef-911d-bf8f22936843',
                'menu_id'       => '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97',
                'name'          => 't_paket:create',
                'description'   => 't_paket:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'b6d3efe0-3158-11ef-9733-91b0237e8ab9',
                'menu_id'       => '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97',
                'name'          => 't_paket:update',
                'description'   => 't_paket:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'bcacbb80-3158-11ef-a628-730cac43d5ee',
                'menu_id'       => '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97',
                'name'          => 't_paket:delete',
                'description'   => 't_paket:delete',
                'created_at'    => Carbon::now()
            ],
            // Setting -> Santri
            [
                'id'            => '632c53f0-3158-11ef-8dca-899e978d9a0a',
                'menu_id'       => 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca',
                'name'          => 'mst_santri:read',
                'description'   => 'mst_santri:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '8d592ac0-3158-11ef-b76f-71a8428885eb',
                'menu_id'       => 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca',
                'name'          => 'mst_santri:create',
                'description'   => 'mst_santri:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '93fb1220-3158-11ef-87e5-914f9a32a81d',
                'menu_id'       => 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca',
                'name'          => 'mst_santri:update',
                'description'   => 'mst_santri:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '992885b0-3158-11ef-82f3-3709d3854c3d',
                'menu_id'       => 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca',
                'name'          => 'mst_santri:delete',
                'description'   => 'mst_santri:delete',
                'created_at'    => Carbon::now()
            ],
            // Setting -> Kategori Paket
            [
                'id'            => 'c43c6250-3158-11ef-82ca-7f207ef271c1',
                'menu_id'       => '2d2a0c90-3158-11ef-b0cf-5bce39cf270a',
                'name'          => 'mst_kategori_paket:read',
                'description'   => 'mst_kategori_paket:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'd2e177a0-3158-11ef-9fd6-95e4d0183a0a',
                'menu_id'       => '2d2a0c90-3158-11ef-b0cf-5bce39cf270a',
                'name'          => 'mst_kategori_paket:create',
                'description'   => 'mst_kategori_paket:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'ce850d70-3158-11ef-805c-571ec4b0dba9',
                'menu_id'       => '2d2a0c90-3158-11ef-b0cf-5bce39cf270a',
                'name'          => 'mst_kategori_paket:update',
                'description'   => 'mst_kategori_paket:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'd7573640-3158-11ef-a8b0-d310acca71a8',
                'menu_id'       => '2d2a0c90-3158-11ef-b0cf-5bce39cf270a',
                'name'          => 'mst_kategori_paket:delete',
                'description'   => 'mst_kategori_paket:delete',
                'created_at'    => Carbon::now()
            ],
            // Setting -> Asrama
            [
                'id'            => 'e59d75c0-3158-11ef-981c-bdab2b06d7ab',
                'menu_id'       => '3a377a90-3158-11ef-bbc6-9bf542ea8a91',
                'name'          => 'mst_asrama:read',
                'description'   => 'mst_asrama:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'e9e2e150-3158-11ef-9b24-c5cf8c30b563',
                'menu_id'       => '3a377a90-3158-11ef-bbc6-9bf542ea8a91',
                'name'          => 'mst_asrama:create',
                'description'   => 'mst_asrama:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'ef5eb9f0-3158-11ef-8226-11e456c60cee',
                'menu_id'       => '3a377a90-3158-11ef-bbc6-9bf542ea8a91',
                'name'          => 'mst_asrama:update',
                'description'   => 'mst_asrama:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'f2ad7350-3158-11ef-bd51-dfed8006565b',
                'menu_id'       => '3a377a90-3158-11ef-bbc6-9bf542ea8a91',
                'name'          => 'mst_asrama:delete',
                'description'   => 'mst_asrama:delete',
                'created_at'    => Carbon::now()
            ],
            // User
            [
                'id'            => '9c45a610-3e35-11ed-b616-bb2a0c5878de',
                'menu_id'       => '60db5290-3e35-11ed-ad15-f5deea1ad299',
                'name'          => 'user:read',
                'description'   => 'user:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'a06404c0-3e35-11ed-8b8c-f36c367192ad',
                'menu_id'       => '60db5290-3e35-11ed-ad15-f5deea1ad299',
                'name'          => 'user:create',
                'description'   => 'user:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'a3e6d460-3e35-11ed-a3d2-058c4fc89cd3',
                'menu_id'       => '60db5290-3e35-11ed-ad15-f5deea1ad299',
                'name'          => 'user:update',
                'description'   => 'user:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => 'a9348770-3e35-11ed-b86c-07b168af0e90',
                'menu_id'       => '60db5290-3e35-11ed-ad15-f5deea1ad299',
                'name'          => 'user:delete',
                'description'   => 'user:delete',
                'created_at'    => Carbon::now()
            ],
            // Role
            [
                'id'            => '09e3a860-5f0a-11ed-b7d2-696df24549b4',
                'menu_id'       => 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b',
                'name'          => 'role:read',
                'description'   => 'role:read',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '0da44230-5f0a-11ed-adf6-ad15bedb8f47',
                'menu_id'       => 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b',
                'name'          => 'role:create',
                'description'   => 'role:create',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '10b72620-5f0a-11ed-8832-af7c26253484',
                'menu_id'       => 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b',
                'name'          => 'role:update',
                'description'   => 'role:update',
                'created_at'    => Carbon::now()
            ],
            [
                'id'            => '13bd20a0-5f0a-11ed-b64c-b1748a8c2a28',
                'menu_id'       => 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b',
                'name'          => 'role:delete',
                'description'   => 'role:delete',
                'created_at'    => Carbon::now()
            ],
        ];
        CoreMenuAbility::insert($abilities);
    }
}
