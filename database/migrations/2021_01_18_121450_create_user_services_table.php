<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_services', function (Blueprint $table) {
            $table->id();
            $table->string("ar_title");
            $table->string("en_title");
            $table->string("type");
            $table->string("ar_description");
            $table->string("en_description");
            $table->string("brand")->nullable();
            $table->decimal("price");
            $table->integer("discount")->default(0);
            $table->integer("quantity")->default(0);

            $table->string("en_color")->nullable();
            $table->string("ar_color")->nullable();
            
            $table->string("image_link")->nullable();
            $table->string("available_from")->nullable();
            $table->string("available_to")->nullable();
            $table->string("manfacture_country")->nullable();
            $table->integer("no_available_items")->nullable();
            $table->integer("no_services_requested")->nullable();

            //request attributes
            $table->string("state")->nullable();
            $table->string("request_note")->nullable();
            $table->dateTime("request_time")->nullable();
            $table->string("response_note")->nullable();
            $table->dateTime("response_time")->nullable();
            $table->string("booking_time")->nullable();
            $table->string("booking_date")->nullable();
            $table->string("payment_method")->nullable();
            $table->string("customer_phone")->nullable();
            $table->string("customer_name")->nullable();
            $table->string("service_name")->nullable();
            $table->string("delivery_type")->nullable();
            $table->string("delivery_fees")->nullable();
            $table->string("service_type"); //delivery or onsite
            $table->string("receiving_date")->nullable(); //delivery or onsite
            $table->string("category_type")->nullable(); //

            $table->string("source_latitude")->nullable();
            $table->string("source_longitude")->nullable();
            $table->string("source_address")->nullable();
            $table->string("winsh_id")->nullable();
            $table->string("winsh_driver_phone")->nullable();
            $table->string("car_brand")->nullable();
            $table->string("car_model")->nullable();
            $table->string("car_year")->nullable();
            $table->string("destination_address")->nullable();
            $table->string("destination_latitude")->nullable();
            $table->string("destination_longitude")->nullable();
            $table->string("min_cost_per_kilo")->nullable();
            $table->string("max_cost_per_kilo")->nullable();
            $table->string("distance")->nullable();

            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_category_id');

            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

           // $table->foreign("service_id")->references("id")->on("services")->onDelete("cascade");
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
        Schema::dropIfExists('user_services');
    }
}
