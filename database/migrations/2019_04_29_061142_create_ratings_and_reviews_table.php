<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsAndReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings_and_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rating');
            $table->text('review');
            $table->enum('approved', ['1', '0'])->default('0')->comment('1 = Approved; 0 = Not Approved');
            $table->enum('spam', ['1', '0'])->default('0')->comment('1 = Spam; 0 = Not Spam');
            $table->bigInteger('listing_id')->unsigned();
            $table->foreign('listing_id')->references('id')->on('listings')
                    ->onUpdate('cascade')->onDelete('no action');
            $table->integer('posted_by')->unsigned();
            $table->foreign('posted_by')->references('id')->on('users')
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
        Schema::dropIfExists('ratings_and_reviews');
    }
}
