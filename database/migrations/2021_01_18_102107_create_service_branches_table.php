<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("service_id");
            $table->unsignedBigInteger("branch_id");
            $table->foreign("branch_id")->references("id")->on("branches")->onDelete("cascade");
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
        Schema::dropIfExists('service_branches');
    }
}
