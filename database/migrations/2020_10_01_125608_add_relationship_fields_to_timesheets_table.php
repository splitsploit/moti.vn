<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimesheetsTable extends Migration
{
    public function up()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->foreign('user_id', 'user_fk_1001496')->references('id')->on('users');
        });
    }
}
