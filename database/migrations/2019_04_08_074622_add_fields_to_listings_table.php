<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->enum('is_approved', ['1', '0'])->default('0')->comment('1 = Yes; 0 = No')->after('status');
            $table->integer('deleted_by')->unsigned()->nullable()->last();
            $table->foreign('deleted_by')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('set null');
            $table->enum('founder_pick', ['1', '0'])->default('0')->comment('1 = Yes; 0 = No')->after('is_approved');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('is_approved');
            $table->dropColumn('deleted_by');
            $table->dropColumn('deleted_at');
        });
    }
}
