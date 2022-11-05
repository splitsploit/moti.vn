<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimekeepingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timekeepings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user')->nullable();;
            $table->string('role')->nullable();;
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->integer('normal_time');
            $table->integer('special_time');
            $table->integer('total_time');
            $table->double('basic_salary');
            $table->double('reward_salary');
            $table->double('reward_percent');
            $table->double('salary');
            $table->double('reward');
            $table->double('total');
            $table->timestamps();
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
        Schema::dropIfExists('timekeepings');
    }
}
