<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Schema::enableForeignKeyConstraints();
Schema::disableForeignKeyConstraints();

class CreateDispatchesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_no');
            $table->string('reference');
            $table->integer('driver_id')->unsigned();
            $table->date('cdate');
            $table->integer('from_')->unsigned();
            $table->integer('to_')->defualt('0');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('confirmed_by')->defualt('0');
            $table->timestamps();

            //  Laravel also provides support for creating foreign key constraints,
            // which are used to force referential integrity at the database level

            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('from_')->references('id')->on('regions');

            //To drop a foreign key, you may use the dropForeign method.
            // Foreign key constraints use the same naming convention as indexes

            $table->dropForeign(['user_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['from_']);


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('vehicle_id')
                ->references('id')->on('vehicles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('driver_id')
                ->references('id')->on('drivers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('from_')
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
        Schema::dropIfExists('dispatches');
    }
}
