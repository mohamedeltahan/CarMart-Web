<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("longitude");
            $table->string("latitude");
            $table->string("email");
            $table->string("city");
            $table->string("address");
            $table->string("phone");
            $table->time("start_time");
            $table->time("end_time");
            $table->unsignedBigInteger("vendor_id");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('branches');
    }
}
