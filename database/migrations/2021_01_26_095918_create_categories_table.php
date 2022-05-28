<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("ar_title");
            $table->string("en_title");
            $table->string("photo_link");
            $table->string("ar_description")->nullable();
            $table->string("en_description")->nullable();
            $table->string("icon");
            $table->string("color_code")->nullable();
            $table->string("colored_icon")->nullable();
            $table->string("sub_categories")->default("['']");
            $table->string('map_icon')->nullable();

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
        Schema::dropIfExists('categories');
    }
}
