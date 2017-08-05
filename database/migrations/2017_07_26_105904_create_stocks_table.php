<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->bigInteger('quantity')->unsigned();
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('item_id')->references('id')->on('items');

            //To drop a foreign key, you may use the dropForeign method.
            // Foreign key constraints use the same naming convention as indexes

            $table->dropForeign(['item_id']);
            $table->dropForeign(['region_id']);


            $table->foreign('item_id')
                ->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('region_id')
                ->references('id')->on('regions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
