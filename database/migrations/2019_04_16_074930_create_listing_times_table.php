<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('start_time');
            $table->time('end_time');
            $table->bigInteger('listing_id')->unsigned()->nullable();
            $table->foreign('listing_id')->references('id')->on('listings')
                    ->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('listing_times');
    }
}
