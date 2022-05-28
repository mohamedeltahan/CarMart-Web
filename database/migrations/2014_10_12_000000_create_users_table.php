<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');                 //user full name
            $table->string('description',300);                 //user description
            $table->string('account_name')->unique();     //user account name
            $table->string('phone')->nullable();           //user phone number registered with
            $table->string('address')->nullable();                   // user  physical address
            $table->string('login_method')->nullable();              // phone_number or facebook or gmail
            $table->string('account_type');              // admin or vendor or normal_user
            $table->boolean('verified')->default(false);      //bool to know if user verified (sms method)
            $table->boolean('blocked')->default(false);       //bool to check if user blocked or not after login attempt
            $table->boolean('featured')->default(false);      //bool to determine if vendor featured or not
            $table->string('email')->unique();
            $table->string('category_title')->nullable();
            $table->string('photo_link')->nullable();
            $table->string('gender')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('specifications',500)->nullable();
            $table->string('city')->nullable();
            $table->integer('number_of_completed_request')->default(0);
            $table->string('forget_password_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('device_token')->nullable();

            $table->string('password');
            $table->string('level')->nullable();
            $table->string('phone_type')->nullable();
            $table->string('working_hours_from')->nullable();
            $table->string('working_hours_to')->nullable();
            $table->string('vacations')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
