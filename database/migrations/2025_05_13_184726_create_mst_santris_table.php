<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_santris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nis', 100)->nullable();
            $table->string('nama', 100)->nullable();
            $table->text('alamat', 00)->nullable();
            $table->foreignUuid('asrama_id')->nullable()->references('id')->on('mst_asramas')->cascadeOnDelete();
            $table->integer('total_paket')->default(0);
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
        Schema::dropIfExists('mst_santris');
    }
}
