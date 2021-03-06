<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('messages', function($table) {

            $table->increments('id');
            $table->string('msg_text');
            $table->integer('msg_from')->unsigned();
            $table->integer('msg_to')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->char('read_ind')->default('N');
            $table->char('action_ind')->default('N');
            $table->timestamps();
                # Define foreign keys...
            $table->foreign('msg_from')->references('id')->on('users');
            $table->foreign('msg_to')->references('id')->on('users');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('messages');
    }

}
