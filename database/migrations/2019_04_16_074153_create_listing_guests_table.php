<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('adults', ['1', '0'])->default('0')->comment('1 = Allowed; 0 = Not Allowed');
            $table->enum('children', ['1', '0'])->default('0')->comment('1 = Allowed; 0 = Not Allowed');
            $table->enum('infants', ['1', '0'])->default('0')->comment('1 = Allowed; 0 = Not Allowed');
            $table->integer('total_count');
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
        Schema::dropIfExists('listing_guests');
    }
}
