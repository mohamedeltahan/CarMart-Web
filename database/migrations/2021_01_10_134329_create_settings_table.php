<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("users_photos_link")->nullable();
            $table->string("categories_photos_link")->nullable();
            $table->string("services_photos_link")->nullable();
            $table->string("specifications_photos_link")->nullable();
            $table->string("banners_photos_link")->nullable();
            $table->string("notifications_photos_link")->nullable();
            $table->string("featured_vendors_photos_link")->nullable();
            $table->string("winsh_average_fees")->nullable();
            $table->string("winsh_min_fees")->nullable();
            $table->string("winsh_max_fees")->nullable();
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
        Schema::dropIfExists('settings');
    }
}
