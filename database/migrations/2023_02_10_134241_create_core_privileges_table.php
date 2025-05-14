<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_privileges', function (Blueprint $table) {
            $table->uuid('role_id');
            $table->uuid('ability_id');

            $table->foreign('role_id')->references('id')->on('core_roles')->cascadeOnDelete();
            $table->foreign('ability_id')->references('id')->on('core_menu_abilities')->cascadeOnDelete();

            $table->primary(['role_id', 'ability_id']);
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
        Schema::dropIfExists('core_privileges');
    }
}
