<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreezersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */































    //    public function up()
//    {
//        Schema::create('freezers', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('ftn_no');
//            $table->string('reference');
//            $table->date('ftn_date');
//            $table->integer('customer_id')->unsigned();
//            $table->string('to_');
//            $table->date('placement_date');
//            $table->string('purpose');
//            $table->integer('from_')->unsigned();
//            $table->string('serialNumber');
//            $table->timestamps();
//
//            $table->foreign('from_')->references('id')->on('regions');
//            $table->foreign('customer_id')->references('id')->on('customers');
//
//            $table->dropForeign(['from_']);
//            $table->dropForeign(['customer_id']);
//
//            $table->foreign('from_')
//                ->references('id')->on('regions')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//            $table->foreign('customer_id')
//                ->references('id')->on('customers')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//
//        });
//        Schema::create('freezers_details', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('customer_id')->unsigned();
//            $table->integer('sales_invoice')->unsigned();
//            $table->integer('item_id')->unsigned();
//            $table->integer('quantity')->unsigned();
//            $table->integer('faculty_id')->unsigned();
//            $table->timestamps();
//
//            $table->foreign('customer_id')->references('id')->on('customers');
//            $table->foreign('item_id')->references('id')->on('items');
//            $table->foreign('faculty_id')->references('id')->on('faculties');
//
//            $table->dropForeign(['customer_id']);
//            $table->dropForeign(['item_id']);
//            $table->dropForeign(['faculty_id']);
//
//            $table->foreign('faculty_id')
//                ->references('id')->on('faculties')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//            $table->foreign('customer_id')
//                ->references('id')->on('customers')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//            $table->foreign('item_id')
//                ->references('id')->on('items')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//        });
//    }
//
//    /**
//     * Reverse the migrations.
//     *
//     * @return void
//     */
//    public function down()
//    {
//        Schema::dropIfExists('freezers');
//        Schema::dropIfExists('freezers_details');
//    }
}
