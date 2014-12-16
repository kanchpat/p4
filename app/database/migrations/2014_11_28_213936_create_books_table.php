<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('books', function($table) {

            # AI, PK
            $table->increments('id');

            # created_at, updated_at columns
            $table->timestamps();

            # General data...
            $table->string('title');
            $table->integer('owner_id')->unsigned(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
            $table->string('author');
            $table->string('isbn');
            $table->string('cover');
            $table->string('ready_to_swap')->default('N');

            # Define foreign keys...
            $table->foreign('owner_id')->references('id')->on('users');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('books');
	}

}
