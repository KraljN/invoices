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
            $table->string('username', 50);
            $table->string('password', 255);
            $table->bigInteger('vat');
            $table->bigInteger('bank_account_number');
            $table->string('address', 50);
            $table->bigInteger('registration_number');
            $table->string('email', 50);
            $table->boolean('is_active');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->timestamps();
            $table->integer('zip');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
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
