<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSpecialTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specical_time', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable();
            $table->foreign('role_id', 'class_fk_1001570')->references('id')->on('roles');
        });
    }
}
