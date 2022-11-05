<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAvailableBookingTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('available_booking_time', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable();
            $table->foreign('role_id', 'class_fk_1001550')->references('id')->on('roles');
        });
    }
}
