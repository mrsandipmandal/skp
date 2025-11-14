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
        Schema::create('main_signup', function (Blueprint $table) {
            $table->id("sl");
            $table->string('username')->unique();
            $table->text('password');
            $table->text('pass');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('actnum')->default(0);
            $table->tinyInteger('userlevel');
            $table->text('dev_id')->nullable();
            $table->tinyInteger('stat')->nullable();
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
        Schema::dropIfExists('main_signup');
    }
};
