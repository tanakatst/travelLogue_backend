<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('date_plan_id');
            $table->string('place_name');
            $table->text('content');
            $table->boolean('is_start');
            $table->boolean('is_destination');
            $table->string('leave_time');
            $table->string('arrived_time');
            $table->string('stay_time');
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
        Schema::dropIfExists('place_plans');
    }
}
