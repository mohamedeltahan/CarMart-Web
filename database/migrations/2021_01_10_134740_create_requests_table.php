<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();  
            $table->string("state");
            $table->string("request_note");
            $table->dateTime("request_time");
            $table->string("response_note");
            $table->dateTime("response_time")->nullable();
            $table->string("source_latitude");
            $table->string("source_longitude");
            $table->string("source_address")->nullable();
            $table->string("winsh_id")->nullable();
            $table->string("winsh_driver_phone")->nullable();
            $table->string("car_brand")->nullable();
            $table->string("car_model")->nullable();
            $table->string("car_year")->nullable();
            $table->string("destination_address")->nullable();
            $table->string("destination_latitude");
            $table->string("destination_longitude");
            
            $table->unsignedBigInteger('service_id');
            $table->foreign("service_id")->references("id")->on("services")->onDelete("cascade");

            
            
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
        Schema::dropIfExists('requests');
    }
}
