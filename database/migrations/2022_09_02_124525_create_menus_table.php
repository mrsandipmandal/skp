<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id("sl");
            $table->string('menu_name')->nullable();
            $table->string('route_name')->nullable();
            $table->integer('root_menu')->default(0);
            $table->integer('ordr')->default(0);
            $table->string('icon')->nullable();
            $table->string('user')->nullable();
            $table->tinyInteger('isall')->default(0);
            $table->tinyInteger('stat')->default(0);
            $table->tinyInteger('is_edit')->default(0);
            $table->tinyInteger('is_delete')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_export')->default(0);
            $table->string('eby')->nullable();
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
        Schema::dropIfExists('menus');
    }
};
