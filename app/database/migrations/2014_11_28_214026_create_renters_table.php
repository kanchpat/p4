<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('renters', function($table) {

            # AI, PK
            $table->increments('id');

            # created_at, updated_at columns
            $table->timestamps();

            # General data...
            $table->integer('renter_id')->unsigned(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
            $table->date('rental_date');
            $table->date('return_date');
            $table->char('return_ind')->default(' ');

            # Define foreign keys...
            $table->foreign('renter_id')->references('id')->on('users');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('renters');
	}

}
