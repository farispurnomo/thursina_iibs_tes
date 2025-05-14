<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Laporan\LapPaketController;
use App\Http\Controllers\Admin\Paket\PaketController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\AsramaController;
use App\Http\Controllers\Admin\Setting\KategoriPaketController;
use App\Http\Controllers\Admin\Setting\SantriController;
use App\Http\Controllers\Admin\Users\Role\RoleController;
use App\Http\Controllers\Admin\Users\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn() => redirect()->route('auth.login'));

Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('autenticate', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['as' => 'password.', 'prefix' => 'password'], function () {
        Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
        Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
        Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');
    });
});

Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::post('/', [ProfileController::class, 'store'])->name('store');
        });

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/get_chart_paket/{mode}', [DashboardController::class, 'get_chart_paket'])->name('dashboard.get_chart_paket');

        Route::group(['as' => 'laporan.', 'prefix' => 'laporan'], function () {
            Route::post('paket/paginate', [LapPaketController::class, 'paginate'])->name('paket.paginate');
            Route::get('paket', [LapPaketController::class, 'index'])->name('paket.index');
        });

        Route::post('paket/paginate', [PaketController::class, 'paginate'])->name('paket.paginate');
        Route::post('export/paginate', [PaketController::class, 'export'])->name('paket.export');
        Route::resource('paket', PaketController::class)->except('show');

        Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
            Route::post('asrama/paginate', [AsramaController::class, 'paginate'])->name('asrama.paginate');
            Route::get('asrama/options', [AsramaController::class, 'options'])->name('asrama.options');
            Route::resource('asrama', AsramaController::class)->except('show');

            Route::post('kategori_paket/paginate', [KategoriPaketController::class, 'paginate'])->name('kategori_paket.paginate');
            Route::get('kategori_paket/options', [KategoriPaketController::class, 'options'])->name('kategori_paket.options');
            Route::resource('kategori_paket', KategoriPaketController::class)->except('show');

            Route::get('santri/options', [SantriController::class, 'options'])->name('santri.options');
            Route::post('santri/paginate', [SantriController::class, 'paginate'])->name('santri.paginate');
            Route::get('santri/{id}/cetak', [SantriController::class, 'cetak'])->name('santri.cetak');
            Route::post('santri/import', [SantriController::class, 'import'])->name('santri.import');
            Route::get('santri/export', [SantriController::class, 'export'])->name('santri.export');
            Route::resource('santri', SantriController::class);
        });

        Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
            Route::post('user/paginate', [UserController::class, 'paginate'])->name('user.paginate');
            Route::get('user/all', [UserController::class, 'all'])->name('user.all');
            Route::get('user/export', [UserController::class, 'export'])->name('user.export');
            Route::resource('user', UserController::class)->except('show');

            Route::resource('role', RoleController::class)->except('show');
            Route::get('role/all', [RoleController::class, 'all'])->name('role.all');
            Route::post('role/paginate', [RoleController::class, 'paginate'])->name('role.paginate');
            Route::get('role/{id}/privilege', [RoleController::class, 'privilege'])->name('role.privilege');
            Route::post('role/{id}/privilege', [RoleController::class, 'storePrivilege'])->name('role.store_privilege');
        });
    });
});
