<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('schedules', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('remote_schedule_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('api_root');
            $table->timestamp('start_time');
            $table->string('selected_date');
            $table->string('api_key');
            $table->string('days_of_month')->nullable();
            $table->integer('start_minute');
            $table->string('hours_of_day');
            $table->string('days_of_week')->nullable();
            $table->string('repeat_frequency');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
