<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookRenterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('book_renter', function($table) {

            # AI, PK
            # none needed

            # General data...
            $table->integer('book_id')->unsigned();
            $table->integer('renter_id')->unsigned();

            # Define foreign keys...
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('book_renter');
    }

}
