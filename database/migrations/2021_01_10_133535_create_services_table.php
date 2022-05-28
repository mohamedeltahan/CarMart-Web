<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string("en_title")->nullable();
            $table->string("ar_title")->nullable();
            $table->string("en_category")->nullable();
            $table->string("ar_category")->nullable();

            $table->string("type")->nullable();
            $table->string("en_description")->nullable();
            $table->string("ar_description")->nullable();
            $table->string("brand")->nullable();
            $table->decimal("price");
            $table->integer("discount")->default(0);
            $table->string("en_color")->nullable();
            $table->string("ar_color")->nullable();
            $table->string("image_link")->nullable();
            $table->string("available_from")->nullable();
            $table->string("available_to")->nullable();
            $table->string("manfacture_country")->nullable();
            $table->integer("no_available_items")->nullable();
            $table->integer("no_services_requested")->nullable();
            $table->boolean("promoted")->nullable();
            $table->boolean("deliverable")->nullable();
            $table->string("ratio")->nullable();
            $table->unsignedBigInteger("branch_id")->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('sub_category_id');

            $table->foreign("vendor_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("sub_category_id")->references("id")->on("sub_categories")->onDelete("cascade");


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
        Schema::dropIfExists('services');
    }
}
