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
            $table->integer('user_id')->unsigned();
            $table->char('read_ind');
            $table->timestamps();
                # Define foreign keys...
            $table->foreign('user_id')->references('id')->on('users');

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
