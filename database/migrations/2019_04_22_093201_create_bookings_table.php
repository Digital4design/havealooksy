<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('no_of_seats');
            $table->bigInteger('time_slot')->unsigned();
            $table->foreign('time_slot')->references('id')->on('listing_times')
                    ->onUpdate('cascade')->onDelete('no action');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('booking_status')
                    ->onUpdate('cascade')->onDelete('set null');
            $table->bigInteger('listing_id')->unsigned()->nullable();
            $table->foreign('listing_id')->references('id')->on('listings')
                    ->onUpdate('cascade')->onDelete('set null');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('bookings');
    }
}
