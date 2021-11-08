<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_name");
            $table->date('date_created');
            $table->dateTime('date_of_traffic');
            $table->dateTime('end_date');
            $table->text('note');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('invoice_statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
