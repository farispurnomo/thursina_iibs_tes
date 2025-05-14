<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pakets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 100)->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->foreignUuid('kategori_id')->references('id')->on('mst_kategori_pakets')->cascadeOnDelete();
            $table->foreignUuid('asrama_id')->references('id')->on('mst_asramas')->cascadeOnDelete();
            $table->foreignUuid('penerima_id')->references('id')->on('mst_santris')->cascadeOnDelete();
            $table->string('pengirim', 100)->nullable();
            $table->string('isi_yg_disita', 200)->nullable();
            $table->string('status', 50)->nullable()->comment('diambil,belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_pakets');
    }
}
