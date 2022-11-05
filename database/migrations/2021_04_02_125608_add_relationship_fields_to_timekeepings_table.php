<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimekeepingsTable extends Migration
{
    public function up()
    {
        Schema::table('timekeepings', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->foreign('user_id', 'user_fk_1001499')->references('id')->on('users');
            $table->unsignedBigInteger('timesheet_id');
            $table->foreign('timesheet_id', 'timekeet_fk_1001111')->references('id')->on('timesheets');
        });
    }
}
