<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ftn_no');
            $table->string('reference');
            $table->date('ftn_date');
            $table->integer('customer_id')->unsigned();
            $table->string('to_');
            $table->date('placement_date');
            $table->string('purpose');


            $table->timestamps();


            $table->foreign('customer_id')->references('id')->on('customers');


            $table->dropForeign(['customer_id']);


            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->string('serialNumber');
            $table->string('type');
            $table->integer('quantity')->unsigned();
            $table->integer('faculty_id')->unsigned();
            $table->integer('transfer_id')->unsigned();
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('transfer_id')->references('id')->on('transfers');

            $table->dropForeign(['region_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['item_id']);
            $table->dropForeign(['faculty_id']);
            $table->dropForeign(['transfer_id']);

            $table->foreign('faculty_id')
                ->references('id')->on('faculties')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('transfer_id')
                ->references('id')->on('transfers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('region_id')
                ->references('id')->on('regions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('item_id')
                ->references('id')->on('items')
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
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('transfer_details');
    }

















    //    public function up()
//    {
//        Schema::create('transfers', function (Blueprint $table) {
//                $table->increments('id');
//                $table->string('doc_no');
//                $table->string('reference');
//                $table->integer('driver_id')->unsigned();
//                $table->integer('customer_id')->unsigned();
//                $table->date('cdate');
//                $table->integer('from_')->unsigned();
//                $table->integer('to_')->defualt('0');
//                $table->integer('vehicle_id')->unsigned();
//                $table->integer('user_id')->unsigned();
//                $table->integer('confirmed_by')->defualt('0');
//                $table->timestamps();
//
//                //  Laravel also provides support for creating foreign key constraints,
//                // which are used to force referential integrity at the database level
//
//                $table->foreign('driver_id')->references('id')->on('drivers');
//                $table->foreign('vehicle_id')->references('id')->on('vehicles');
//                $table->foreign('user_id')->references('id')->on('users');
//                $table->foreign('from_')->references('id')->on('regions');
//
//                //To drop a foreign key, you may use the dropForeign method.
//                // Foreign key constraints use the same naming convention as indexes
//
//                $table->dropForeign(['user_id']);
//                $table->dropForeign(['vehicle_id']);
//                $table->dropForeign(['driver_id']);
//                $table->dropForeign(['from_']);
//
//
//                $table->foreign('user_id')
//                    ->references('id')->on('users')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//                $table->foreign('vehicle_id')
//                    ->references('id')->on('vehicles')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//                $table->foreign('driver_id')
//                    ->references('id')->on('drivers')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//                $table->foreign('from_')
//                    ->references('id')->on('regions')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//
//
//            });
//            Schema::create('transfers_detail', function (Blueprint $table) {
//                $table->increments('id');
//                $table->integer('customer_id')->unsigned();
//                $table->integer('sales_invoice')->unsigned();
//                $table->integer('item_id')->unsigned();
//                $table->integer('quantity')->unsigned();
//                $table->timestamps();
//
//                $table->foreign('customer_id')->references('id')->on('customers');
//                $table->foreign('item_id')->references('id')->on('items');
//
//                $table->dropForeign(['customer_id']);
//                $table->dropForeign(['item_id']);
//
//                $table->foreign('customer_id')
//                    ->references('id')->on('customers')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//                $table->foreign('item_id')
//                    ->references('id')->on('items')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//            });
//    }
//
//    /**
//     * Reverse the migrations.
//     *
//     * @return void
//     */
//    public function down()
//    {
//        Schema::dropIfExists('transfers');
//    }
}
