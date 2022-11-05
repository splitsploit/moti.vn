<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingTimeTable extends Migration
{
    public function up()
    {
        Schema::table('booking_time', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->foreign('user_id', 'user_fk_1001596')->references('id')->on('users');
        });
    }
}
