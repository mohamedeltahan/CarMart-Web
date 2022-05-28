<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("type")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            
            $table->unsignedBigInteger("vendor_id")->nullable();
            //$table->foreign("vendor_id")->references("id")->on("users")->onDelete("cascade");

            $table->boolean("seen")->default(0);
            $table->string("description");
            $table->string("image_link")->nullable();
            $table->string("target_audience")->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
