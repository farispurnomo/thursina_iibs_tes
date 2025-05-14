<?php

namespace Database\Seeders;

use App\Models\CoreMenu;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CoreMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CoreMenu::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $menus = [
            // -> Dashboard
            [
                'id'            => '1b0d37e0-33d8-11ed-bceb-57a813f27781',
                'url'           => 'admin/dashboard',
                'title'         => 'Dashboard',
                'icon'          => 'fas fa-tachometer-alt',
                'parent_id'     => null,
                'order'         => 0,
                'created_at'    => Carbon::now()
            ],
            // -> Laporan
            [
                'id'            => 'aa6e5860-36c5-11ef-a781-97906a43167c',
                'url'           => 'admin/laporan',
                'title'         => 'Laporan',
                'icon'          => 'fas fa-file-alt',
                'parent_id'     => null,
                'order'         => 2,
                'created_at'    => Carbon::now()
            ],
            // -> Laporan -> Paket
            [
                'id'            => 'f51eaec0-36c5-11ef-8838-e5f828db163c',
                'url'           => 'admin/laporan/paket',
                'title'         => 'Paket',
                'icon'          => null,
                'parent_id'     => 'aa6e5860-36c5-11ef-a781-97906a43167c',
                'order'         => 0,
                'created_at'    => Carbon::now()
            ],
            // -> Paket
            [
                'id'            => '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97',
                'url'           => 'admin/paket',
                'title'         => 'Paket',
                'icon'          => 'fas fa-box',
                'parent_id'     => null,
                'order'         => 3,
                'created_at'    => Carbon::now()
            ],
            // -> Setting
            [
                'id'            => 'acf0b360-ad85-11ed-a465-974f0ff7e079',
                'url'           => 'admin/settings',
                'title'         => 'Pengaturan',
                'icon'          => 'fas fa-gear',
                'parent_id'     => null,
                'order'         => 4,
                'created_at'    => Carbon::now()
            ],
            // -> Setting -> Santri
            [
                'id'            => 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca',
                'url'           => 'admin/settings/santri',
                'title'         => 'Santri',
                'icon'          => null,
                'parent_id'     => 'acf0b360-ad85-11ed-a465-974f0ff7e079',
                'order'         => 2,
                'created_at'    => Carbon::now()
            ],
            // -> Setting -> Kategori Paket
            [
                'id'            => '2d2a0c90-3158-11ef-b0cf-5bce39cf270a',
                'url'           => 'admin/settings/kategori_paket',
                'title'         => 'Kategori Paket',
                'icon'          => null,
                'parent_id'     => 'acf0b360-ad85-11ed-a465-974f0ff7e079',
                'order'         => 3,
                'created_at'    => Carbon::now()
            ],
            // -> Setting -> Asrama
            [
                'id'            => '3a377a90-3158-11ef-bbc6-9bf542ea8a91',
                'url'           => 'admin/settings/asrama',
                'title'         => 'Asrama',
                'icon'          => null,
                'parent_id'     => 'acf0b360-ad85-11ed-a465-974f0ff7e079',
                'order'         => 4,
                'created_at'    => Carbon::now()
            ],
            // -> User Setting
            [
                'id'            => 'b9f0c9a0-60af-11ed-9109-2d9c58e86481',
                'url'           => 'admin/users',
                'title'         => 'Pengaturan User',
                'icon'          => 'fa fa-user',
                'parent_id'     => null,
                'order'         => 5,
                'created_at'    => Carbon::now()
            ],
            // -> User Setting -> Role
            [
                'id'            => 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b',
                'url'           => 'admin/users/role',
                'title'         => 'Role',
                'icon'          => null,
                'parent_id'     => 'b9f0c9a0-60af-11ed-9109-2d9c58e86481',
                'order'         => 0,
                'created_at'    => Carbon::now()
            ],
            // -> User Setting -> User
            [
                'id'            => '60db5290-3e35-11ed-ad15-f5deea1ad299',
                'url'           => 'admin/users/user',
                'title'         => 'Pengguna',
                'icon'          => null,
                'parent_id'     => 'b9f0c9a0-60af-11ed-9109-2d9c58e86481',
                'order'         => 1,
                'created_at'    => Carbon::now()
            ],
        ];
        CoreMenu::insert($menus);
    }
}
