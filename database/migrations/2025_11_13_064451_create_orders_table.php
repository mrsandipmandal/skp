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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->bigInteger('customer_id');
            $table->text('note')->nullable();
            $table->text('image_path')->nullable();
            $table->string('order_type', 150)->nullable(); // 'Self Pickup','Delivery'
            $table->tinyInteger('stat')->default(0)->comment('0: Pending, 1: Received, 2 : Prepared, 3: completed, 4: cancelled');
            $table->string('received_by', 150)->nullable();
            $table->date('received_dtm')->nullable();
            $table->text('received_note')->nullable();
            $table->string('prepared_by', 150)->nullable();
            $table->date('prepared_dtm')->nullable();
            $table->text('prepared_note')->nullable();
            $table->double('prepared_estimated_amount')->default(0)->nullable();
            $table->string('completed_by', 150)->nullable();
            $table->date('completed_dtm')->nullable();
            $table->text('completed_note')->nullable();
            $table->string('cancelled_by', 150)->nullable();
            $table->date('cancelled_dtm')->nullable();
            $table->text('cancelled_note')->nullable();
            $table->bigInteger('delivery_person_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
